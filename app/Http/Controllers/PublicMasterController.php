<?php

namespace App\Http\Controllers;

use App\Models\Master;
use Illuminate\Http\Request;

class PublicMasterController extends Controller
{
    /**
     * Показати всіх майстрів на сайті разом з графіком роботи.
     */
    public function index()
    {
        $masters = Master::with(['services', 'workingHours'])->get();

        return view('masters.public_index', compact('masters'));
    }
}
