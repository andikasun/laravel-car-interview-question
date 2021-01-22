<?php

namespace App;

use App\Car;
use App\Workshop;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['car_id', 'workshop_id', 'start_time', 'end_time'];
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }
}
