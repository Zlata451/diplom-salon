<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;

class MasterApiController extends Controller
{
    public function getByService(Service $service)
    {
        return response()->json(
            $service->masters()
                ->select('masters.id', 'masters.name', 'masters.specialty')
                ->get()
        );
    }
}
