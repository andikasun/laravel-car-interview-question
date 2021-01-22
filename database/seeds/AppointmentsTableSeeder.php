<?php

use App\Appointment;
use League\Csv\Reader;
use Illuminate\Database\Seeder;

class WorkshopsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csv = Reader::createFromPath('./database/seeds/data/appointments.csv', 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        foreach($records as $record) {
            Appointment::firstOrCreate(
                [
                    'car_id' => $record['car_id'],
                    'workshop_id' => $record['workshop_id'],
                    'start_time' => $record['start_time'],
                    'end_time' => $record['end_time']
                ]
            );
        }
    }
}
