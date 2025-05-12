<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MasterApiController;

Route::get('/services/{service}/masters', [MasterApiController::class, 'getByService']);
