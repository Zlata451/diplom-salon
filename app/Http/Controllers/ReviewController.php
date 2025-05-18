<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\Master;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'master_id' => 'nullable|exists:masters,id',
            'service_id' => 'nullable|exists:services,id',
        ]);

        $validated['user_id'] = Auth::id();

        // 🔁 Полиморфная логика
        $validated['reviewable_type'] = $request->filled('service_id')
            ? Service::class
            : Master::class;

        $validated['reviewable_id'] = $request->service_id ?? $request->master_id;

        Review::create($validated);

        // 🔁 Редирект на нужную детальную страницу
        if ($request->filled('master_id')) {
            return redirect()
                ->route('masters.show', $request->master_id)
                ->with('success', 'Дякуємо за ваш відгук!');
        }

        if ($request->filled('service_id')) {
            return redirect()
                ->route('services.show', $request->service_id)
                ->with('success', 'Дякуємо за ваш відгук!');
        }

        return redirect()->route('home')->with('success', 'Відгук додано!');
    }
}
