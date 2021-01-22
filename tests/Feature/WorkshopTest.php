<?php

namespace Tests\Feature;

use App\Workshop;
use App\Appointment;
use Tests\TestCase;

class WorkshopTest extends TestCase
{
    public function testWorkshopFilteredbyID()
    {
        $workshopData = [
            "workshop_id" => 1
        ];

        $this->json('GET', 'api/v1/workshop', $workshopData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "status" => "SUCCESS",
                "data" =>[
                    [
                        "id"        => 1,
                        "name"      => "Fengshan Workshop",
                        "phone"     => "+6561231234",
                        "latitude"  => 1.3322664,
                        "longitude" => 103.9364883,
                        "opening_time" => "09:00",
                        "closing_time" => "13:00",
                        "appointments" => []
                    ]
                ]
            ]);
    }

    public function testWorkshopFilteredbyName()
    {
        $workshopData = [
            "workshop_name" => "724 Ang Mo Kio Workshop"
        ];

        $this->json('GET', 'api/v1/workshop', $workshopData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "status" => "SUCCESS",
                "data" =>[
                    [
                        "id"        => 2,
                        "name"      => "724 Ang Mo Kio Workshop",
                        "phone"     => "+6566668888",
                        "latitude"  => 1.3721404,
                        "longitude" => 103.8445973,
                        "opening_time" => "12:00",
                        "closing_time" => "16:00",
                        "appointments" => []
                    ]
                ]
            ]);
    }
}