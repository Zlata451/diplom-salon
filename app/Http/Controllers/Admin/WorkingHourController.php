<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Master;
use Illuminate\Http\Request;

class WorkingHourController extends Controller
{
    /**
     * Форма редагування графіка роботи майстра.
     */
    public function edit(Master $master)
    {
        $workingHours = $master->workingHours()->get()->keyBy('day_of_week');

        return view('admin.working-hours.edit', compact('master', 'workingHours'));
    }

    /**
     * Оновлення графіка роботи майстра.
     */
    public function update(Request $request, Master $master)
    {
        $data = $request->validate([
            'working_hours' => 'array',
            'working_hours.*.start_time' => 'nullable|date_format:H:i',
            'working_hours.*.end_time' => 'nullable|date_format:H:i|after:working_hours.*.start_time',
        ]);

        // Очистити старі записи
        $master->workingHours()->delete();

        // Додати нові
        foreach ($data['working_hours'] as $day => $times) {
            if (!empty($times['start_time']) && !empty($times['end_time'])) {
                $master->workingHours()->create([
                    'day_of_week' => $day,
                    'start_time' => $times['start_time'],
                    'end_time' => $times['end_time'],
                ]);
            }
        }

        return redirect()->route('admin.masters.index')->with('success', 'Графік роботи оновлено успішно!');
    }
}
