<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Appointment;
use App\Workshop;

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
                //'end_time' => 'required|date_format:Y-m-d H:i:s|gt:start_time',
                'end_time' => 'required|date_format:Y-m-d H:i:s',
        ]);
         
        if ($validator->fails()) {
            return response()->json(['status' => 'FAILED', 'error' => $validator->messages()], 500);
        }
        
        //check that the workshop is open during the requested time
        $start_datetime = date('H:i', strtotime($request->start_time));
        $end_datetime = date('H:i', strtotime($request->end_time));

        $available = Workshop::where("id", $request->workshop_id)
            ->where('opening_time', '<=', $start_datetime)
            ->where('closing_time', '>=', $end_datetime)
            ->count();

        //no conflict
        $conflict = Appointment::where("workshop_id", $request->workshop_id)
            ->whereBetween('start_time', [$request->start_time, $request->end_time])
            ->whereBetween('end_time', [$request->start_time, $request->end_time])
            ->count();

        if($conflict > 0){
            return response()->json(['status' => 'FAILED', 'error' => 'The timeslot for that appointment has been taken'], 500);
        } else if($available < 1) {
            return response()->json(['status' => 'FAILED', 'error' => 'The workshop is not open during the requested time' ], 500);
        }else {
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

