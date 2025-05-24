<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\Master;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Notifications\{
    AppointmentCreatedNotification,
    AppointmentCanceledNotification,
    AppointmentCreatedForMasterNotification,
    AppointmentCancelledForMasterNotification,
    AppointmentUpdatedForMasterNotification
};

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $query = Appointment::with('user', 'service', 'master')->latest();

        if ($request->filled('status') && in_array($request->status, ['заплановано', 'завершено', 'скасовано'])) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->where('date', $request->date);
        }

        if ($request->filled('master_id')) {
            $query->where('master_id', $request->master_id);
        }

        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        return view('appointments.index', [
            'appointments' => $query->get(),
            'selectedStatus' => $request->status,
            'selectedDate' => $request->date,
            'selectedMaster' => $request->master_id,
            'selectedService' => $request->service_id,
            'masters' => Master::all(),
            'services' => Service::all(),
        ]);
    }

    public function create()
    {
        $services = Service::all();
        $masters = Master::all();
        $users = auth()->user()->role === 'admin' ? User::all() : null;

        return view('appointments.create', compact('services', 'masters', 'users'));
    }

    public function book(Service $service)
    {
        $masters = $service->masters;
        return view('appointments.book', compact('service', 'masters'));
    }

    public function bookWithMaster(Request $request, Master $master)
    {
        $services = $master->services;
        $selectedService = $request->has('service_id') ? $services->firstWhere('id', $request->service_id) : null;

        return view('appointments.book', [
            'master' => $master,
            'services' => $services,
            'service' => $selectedService,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'master_id' => 'required|exists:masters,id',
            'date' => 'required|date',
            'time' => 'required',
        ]);

        $service = Service::with('masters')->findOrFail($validated['service_id']);
        $master = Master::with('workingHours')->findOrFail($validated['master_id']);
        $date = Carbon::parse($validated['date']);
        $time = $validated['time'];

        $appointmentDateTime = Carbon::parse("{$validated['date']} {$validated['time']}");
        if ($appointmentDateTime->isPast()) {
            return back()->with('error', 'Неможливо записатись у минуле')->withInput();
        }

        $dayOfWeek = strtolower($date->englishDayOfWeek);
        $workingHours = $master->workingHours->firstWhere('day_of_week', $dayOfWeek);
        if (!$workingHours) {
            return back()->with('error', 'Майстер не працює у цей день')->withInput();
        }

        $start = Carbon::parse($workingHours->start_time);
        $end = Carbon::parse($workingHours->end_time);
        $timeCarbon = Carbon::parse($time);
        if ($timeCarbon->lt($start) || $timeCarbon->gt($end)) {
            return back()->with('error', 'Обраний час поза межами робочого графіку майстра')->withInput();
        }

        $serviceDuration = $service->duration;
        $latestStartTime = Carbon::parse($workingHours->end_time)->subMinutes($serviceDuration);
        if ($timeCarbon->gt($latestStartTime)) {
            return back()->with('error', 'Недостатньо часу до кінця зміни майстра для цієї послуги')->withInput();
        }

        $exists = Appointment::where('master_id', $validated['master_id'])
            ->where('date', $validated['date'])
            ->where('time', $validated['time'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Майстер уже зайнятий у цей час')->withInput();
        }

        $validated['user_id'] = (auth()->user()->role === 'admin' && $request->has('user_id'))
            ? $request->input('user_id') : Auth::id();

        $validated['status'] = 'заплановано';
        $appointment = Appointment::create($validated);

        Auth::user()->notify(new AppointmentCreatedNotification($appointment));
        $appointment->master->notify(new AppointmentCreatedForMasterNotification($appointment));

        return redirect()->route('services.index')->with('success', 'Запис успішно створено!');
    }

    public function edit(Appointment $appointment)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $services = Service::all();
        $masters = Master::all();

        return view('appointments.edit', compact('appointment', 'services', 'masters'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'master_id' => 'required|exists:masters,id',
            'date' => 'required|date',
            'time' => 'required',
            'status' => 'required|in:заплановано,завершено,скасовано',
        ]);

        $conflict = Appointment::where('id', '!=', $appointment->id)
            ->where('master_id', $validated['master_id'])
            ->where('date', $validated['date'])
            ->where('time', $validated['time'])
            ->exists();

        if ($conflict) {
            return back()->withErrors(['time' => 'Майстер уже зайнятий у цей час'])->withInput();
        }

        $appointment->update($validated);
        $appointment->master->notify(new AppointmentUpdatedForMasterNotification($appointment));

        return redirect()->route('appointments.index')->with('success', 'Запис оновлено успішно!');
    }

    public function destroy(Appointment $appointment)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Запис видалено успішно!');
    }

    public function my(Request $request)
    {
        $query = Appointment::with('service', 'master')
            ->where('user_id', auth()->id())
            ->latest();

        if ($request->has('status') && in_array($request->status, ['заплановано', 'завершено', 'скасовано'])) {
            $query->where('status', $request->status);
        }

        return view('appointments.my', [
            'appointments' => $query->get(),
            'selectedStatus' => $request->status,
        ]);
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $request->validate(['status' => 'required|in:заплановано,завершено,скасовано']);
        $appointment->status = $request->status;
        $appointment->save();

        return redirect()->back()->with('success', 'Статус оновлено успішно!');
    }

    public function cancel(Appointment $appointment)
    {
        if ($appointment->user_id !== auth()->id()) abort(403);
        if ($appointment->status !== 'заплановано') {
            return redirect()->back()->withErrors(['status' => 'Скасувати можна лише заплановані записи.']);
        }

        $appointment->status = 'скасовано';
        $appointment->save();

        auth()->user()->notify(new AppointmentCanceledNotification($appointment));
        $appointment->master->notify(new AppointmentCancelledForMasterNotification($appointment));

        return redirect()->back()->with('success', 'Запис успішно скасовано.');
    }

    public function repeat(Appointment $appointment)
    {
        $this->authorize('view', $appointment);

        return redirect()->route('appointments.bookWithMaster', [
            'master' => $appointment->master_id,
            'service_id' => $appointment->service_id,
        ]);
    }

    public function bookedTimes(Request $request, Master $master)
    {
        $date = $request->query('date');

        if (!$date) {
            return response()->json([], 400);
        }

        $appointments = $master->appointments()
            ->where('date', $date)
            ->where('status', 'заплановано')
            ->pluck('time');

        return response()->json($appointments);
    }
}
