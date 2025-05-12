<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\AppointmentCreatedNotification;
use App\Notifications\AppointmentCanceledNotification; // ✅ исправлено
use App\Notifications\AppointmentCreatedForMasterNotification;
use App\Notifications\AppointmentCancelledForMasterNotification;
use App\Notifications\AppointmentUpdatedForMasterNotification;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $query = Appointment::with('user', 'service', 'master')->latest();

        if ($request->has('status') && in_array($request->status, ['заплановано', 'завершено', 'скасовано'])) {
            $query->where('status', $request->status);
        }

        return view('appointments.index', [
            'appointments' => $query->get(),
            'selectedStatus' => $request->status,
        ]);
    }

    public function create()
    {
        $services = Service::all();
        $masters = Master::all();

        return view('appointments.create', compact('services', 'masters'));
    }

    public function book(Service $service)
    {
        $masters = $service->masters;
        return view('appointments.book', compact('service', 'masters'));
    }

    public function bookWithMaster(Request $request, Master $master)
    {
        $services = $master->services;
        $selectedService = null;

        if ($request->has('service_id')) {
            $selectedService = $services->firstWhere('id', $request->service_id);
        }

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

        if (!$service->masters->contains('id', $validated['master_id'])) {
            return back()->withErrors(['master_id' => 'Обраний майстер не надає цю послугу'])->withInput();
        }

        $exists = Appointment::where('master_id', $validated['master_id'])
            ->where('date', $validated['date'])
            ->where('time', $validated['time'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['time' => 'Майстер уже зайнятий у цей час'])->withInput();
        }

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'заплановано';

        $appointment = Appointment::create($validated);

        // ✉️ Повідомлення клієнту
        Auth::user()->notify(new AppointmentCreatedNotification($appointment));

        // ✉️ Повідомлення майстру
        $appointment->master->notify(new AppointmentCreatedForMasterNotification($appointment));

        return redirect()->route('services.index')->with('success', 'Запис успішно створено!');
    }

    public function edit(Appointment $appointment)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $services = Service::all();
        $masters = Master::all();

        return view('appointments.edit', compact('appointment', 'services', 'masters'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

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

        // ✉️ Повідомлення майстру
        $appointment->master->notify(new AppointmentUpdatedForMasterNotification($appointment));

        return redirect()->route('appointments.index')->with('success', 'Запис оновлено успішно!');
    }

    public function destroy(Appointment $appointment)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

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
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:заплановано,завершено,скасовано',
        ]);

        $appointment->status = $request->status;
        $appointment->save();

        return redirect()->back()->with('success', 'Статус оновлено успішно!');
    }

    public function cancel(Appointment $appointment)
    {
        if ($appointment->user_id !== auth()->id()) {
            abort(403);
        }

        if ($appointment->status !== 'заплановано') {
            return redirect()->back()->withErrors(['status' => 'Скасувати можна лише заплановані записи.']);
        }

        $appointment->status = 'скасовано';
        $appointment->save();

        // ✉️ Повідомлення клієнту
        auth()->user()->notify(new AppointmentCanceledNotification($appointment)); // ✅ исправлено

        // ✉️ Повідомлення майстру
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
}
