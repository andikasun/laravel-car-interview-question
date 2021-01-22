<?php

namespace Tests\Feature;

use App\Workshop;
use App\Appointment;
use Tests\TestCase;

class AppointmentTest extends TestCase
{
    public function testAppointmentCreation()
    {
        $appointmentData = [
            "car_id" => 1,
            'workshop_id' => '2',
            'start_time' => '2021-03-01 13:00:00',
            'end_time' => '2021-03-01 14:00:00',
        ];
        $this->json('POST', 'api/v1/appointment', $appointmentData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "status" => "SUCCESS",
                "data" => [
                    "car_id" => 1,
                    'workshop_id' => '2',
                    'start_time' => '2021-03-01 13:00:00',
                    'end_time' => '2021-03-01 14:00:00',
                ]
            ]);
    }

    public function testAppointmentSlotUnavailable()
    {
        $appointmentData = [
            "car_id" => 1,
            'workshop_id' => '2',
            'start_time' => '2021-03-01 13:00:00',
            'end_time' => '2021-03-01 14:00:00',
        ];
        $this->json('POST', 'api/v1/appointment', $appointmentData, ['Accept' => 'application/json'])
            ->assertStatus(500)
            ->assertJson([
                "status" => "FAILED",
                "error" =>"The timeslot for that appointment has been taken"
            ]);
    }

    public function testAppointmentWorkshopNotOpen()
    {
        $appointmentData = [
            "car_id" => 1,
            'workshop_id' => '2',
            'start_time' => '2021-01-20 10:00:00',
            'end_time' => '2021-01-20 12:00:00',
        ];
        $this->json('POST', 'api/v1/appointment', $appointmentData, ['Accept' => 'application/json'])
            ->assertStatus(500)
            ->assertJson([
                "status" => "FAILED",
                "error" =>"The workshop is not open during the requested time"
            ]);
    }

}