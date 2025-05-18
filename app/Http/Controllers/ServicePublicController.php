<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServicePublicController extends Controller
{
    public function index()
    {
        // ⬇️ Завантажуємо також відгуки для кожної послуги
        $services = Service::with('reviews.user')->get();

        return view('services.index', compact('services'));
    }

    public function show(Service $service)
    {
        // ⬇️ Завантаження відгуків з користувачами
        $service->load('reviews.user');

        return view('services.show', compact('service'));
    }
}
