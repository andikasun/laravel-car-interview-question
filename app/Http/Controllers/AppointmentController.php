<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Appointment;

class AppointmentController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $appointments = Appointment::all();
        return $appointments;
    }

    
    public function show($id) {
        return Appointment::find($id);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'car_id' => 'required',
            'workshop_id' => 'required',
            'start_time' => 'required|date_format:Y-m-d H:i:s',
            'end_time' => 'required|date_format:Y-m-d H:i:s|gt:start_time',
        ]);
         
        if ($validator->fails()) {
            return response()->json(['status' => 'FAILED', 'error' => $validator->messages()], 500);
        }


        //no conflict
        $conflict = Appointment::where("workshop_id", $request->workshop_id)
            ->whereBetween('start_time', [$request->start_time, $request->end_time])
            ->whereBetween('end_time', [$request->start_time, $request->end_time])
            ->count();

        if($conflict > 0){
            return response()->json(['status' => 'FAILED', 'error' => 'The timeslot for that appointment has been taken'], 500);
        } else {
            try {
                return response()->json(['status' => 'SUCCESS', "data" =>Appointment::create([
                    'car_id' => $request->car_id,
                    'workshop_id' => $request->workshop_id,
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time
                ], 200)]);
            } catch(Exception $ex) {
                return response()->json(['status' => 'FAILED', 'error' => 'Error creating appointment'], 500);
            }
        }
        
    }

    public function update(Request $request, $id){
        $article = Appointment::findOrFail($id);
        $article->update($request->all());

        return $article;
    }

    public function delete(Request $request, $id){
        $article = Appointment::findOrFail($id);
        $article->delete();

        return 204;
    }
}

