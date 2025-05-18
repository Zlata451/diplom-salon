<?php

namespace App\Http\Controllers;

use App\Models\Master;
use Illuminate\Http\Request;

class PublicMasterController extends Controller
{
    /**
     * Показати всіх майстрів на сайті разом з графіком роботи та відгуками.
     */
    public function index()
    {
        $masters = Master::with(['services', 'workingHours', 'reviews.user'])->get();

        return view('masters.public_index', compact('masters'));
    }

    /**
     * Показати детальну сторінку одного майстра.
     */
    public function show($id)
    {
        $master = Master::with(['services', 'workingHours', 'reviews.user'])->findOrFail($id);

        return view('masters.show', compact('master'));
    }
}
