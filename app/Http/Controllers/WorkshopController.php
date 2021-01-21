<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Workshop;
use App\Appointment;

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
            $workshop->where('name', $request->input('workshop_name'));
        }


        $workshops = $workshop->with(["appointments","appointments.car"])->get();
        return response()->json(['status' => 'SUCCESS', "data" => $workshops], 200);
    }

    public function recommend(Request $request) {
        $workshop = new Workshop();
        $workshop = $workshop->newQuery();
        $conflict = null;
        if ($request->has('start_time') && $request->has('end_time')) {
            $conflict = Appointment::select('workshop_id')
                ->whereBetween('start_time', [$request->start_time, $request->end_time])
                ->whereBetween('end_time', [$request->start_time, $request->end_time])
                ->get();
        }

        if ($request->has('latitude') && $request->has('longitude')) {
            $workshop->select(DB::raw('*, ST_Distance_Sphere( point(longitude, latitude), point(' . $request->longitude . ', ' . $request->latitude . ') ) as distance'))
                ->orderBy('distance', 'ASC');
        }
        $workshops = $workshop->whereNotIn('id', $conflict)->get();

        try {
            return response()->json(['status' => 'SUCCESS', "data" => $workshops], 200);
        } catch(Exception $ex) {
            return response()->json(['status' => 'FAILED', 'error' => 'Error creating appointment'], 500);
        }

    }
}

