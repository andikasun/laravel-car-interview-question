<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Workshop;

class WorkshopController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(Request $request) {
        $workshop = new Workshop();
        $workshop = $workshop->newQuery();
        if ($request->has('workshop_id')) {
            $workshop->where('id', $request->input('workshop_id'));
        }
        if ($request->has('workshop_name')) {
            $workshop->where('id', $request->input('workshop_name'));
        }


        $workshops = $workshop->with(["appointments","appointments.car"])->get();
        return $workshops;
    }
}

