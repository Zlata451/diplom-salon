<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Master;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MasterController extends Controller
{
    public function index()
    {
        $masters = Master::with('services')->latest()->get();
        return view('admin.masters.index', compact('masters'));
    }

    public function create()
    {
        $services = Service::all();
        return view('admin.masters.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'specialty'  => 'required|string|max:255',
            'phone'      => 'nullable|string|max:20',
            'email'      => 'nullable|email|max:255',
            'photo'      => 'nullable|image|max:2048',
            'services'   => 'nullable|array',
            'services.*' => 'exists:services,id',
            'working_hours' => 'array',
            'working_hours.*.day_off' => 'nullable|in:0,1',
            'working_hours.*.start_time' => 'nullable|date_format:H:i',
            'working_hours.*.end_time' => 'nullable|date_format:H:i|after:working_hours.*.start_time',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('masters', 'public');
        }

        $master = Master::create($validated);

        if (!empty($validated['services'])) {
            $master->services()->sync($validated['services']);
        }

        foreach ($validated['working_hours'] ?? [] as $day => $times) {
            if (($times['day_off'] ?? '0') === '1') {
                continue;
            }

            $startTime = $times['start_time'] ?? null;
            $endTime = $times['end_time'] ?? null;

            if (!$startTime || !$endTime) {
                continue;
            }

            $master->workingHours()->create([
                'day_of_week' => $day,
                'start_time' => $startTime,
                'end_time' => $endTime,
            ]);
        }

        return redirect()->route('admin.masters.index')->with('success', 'Майстра додано успішно!');
    }

    public function edit(Master $master)
    {
        $services = Service::all();
        $master->load('workingHours');

        return view('admin.masters.edit', compact('master', 'services'));
    }

    public function update(Request $request, Master $master)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'specialty'  => 'required|string|max:255',
            'phone'      => 'nullable|string|max:20',
            'email'      => 'nullable|email|max:255',
            'photo'      => 'nullable|image|max:2048',
            'services'   => 'nullable|array',
            'services.*' => 'exists:services,id',
            'working_hours' => 'array',
            'working_hours.*.day_off' => 'nullable|in:0,1',
            'working_hours.*.start_time' => 'nullable|date_format:H:i',
            'working_hours.*.end_time' => 'nullable|date_format:H:i|after:working_hours.*.start_time',
        ]);

        $dataForUpdate = [
            'name' => $validated['name'],
            'specialty' => $validated['specialty'],
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
        ];

        if ($request->hasFile('photo')) {
            if ($master->photo) {
                Storage::disk('public')->delete($master->photo);
            }
            $dataForUpdate['photo'] = $request->file('photo')->store('masters', 'public');
        }

        $master->update($dataForUpdate);
        $master->services()->sync($validated['services'] ?? []);
        $master->workingHours()->delete();

        foreach ($validated['working_hours'] ?? [] as $day => $times) {
            if (($times['day_off'] ?? '0') === '1') {
                continue;
            }

            $startTime = $times['start_time'] ?? null;
            $endTime = $times['end_time'] ?? null;

            if (!$startTime || !$endTime) {
                continue;
            }

            $master->workingHours()->create([
                'day_of_week' => $day,
                'start_time' => $startTime,
                'end_time' => $endTime,
            ]);
        }

        return redirect()->route('admin.masters.index')->with('success', 'Майстра оновлено успішно!');
    }

    public function destroy(Master $master)
    {
        if ($master->photo) {
            Storage::disk('public')->delete($master->photo);
        }

        $master->services()->detach();
        $master->workingHours()->delete();
        $master->delete();

        return redirect()->route('admin.masters.index')->with('success', 'Майстра видалено успішно!');
    }

    /**
     * 📅 API: Графік роботи майстра (українською)
     */
    public function schedule(Master $master)
    {
        $uaDays = [
            'monday'    => 'Понеділок',
            'tuesday'   => 'Вівторок',
            'wednesday' => 'Середа',
            'thursday'  => 'Четвер',
            'friday'    => 'Пʼятниця',
            'saturday'  => 'Субота',
            'sunday'    => 'Неділя',
        ];

        $schedule = $master->workingHours->map(function ($hour) use ($uaDays) {
            return [
                'day' => $uaDays[$hour->day_of_week] ?? ucfirst($hour->day_of_week),
                'from' => substr($hour->start_time, 0, 5),
                'to' => substr($hour->end_time, 0, 5),
            ];
        });

        return response()->json($schedule);
    }
}
