<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $days = [Carbon::MONDAY, Carbon::WEDNESDAY, Carbon::FRIDAY, Carbon::SATURDAY];
        $schedules = [];

        foreach ($days as $day) {
            $data = [];
            $data['day'] = $day;
            $data['opening_time'] = Carbon::createFromTime(8, 0);
            $data['closing_time'] = Carbon::createFromTime(16, 0);
            $data['lunch_start_time'] = Carbon::createFromTime(12, 0);
            $data['lunch_close_time'] = Carbon::createFromTime(12, 45);
            array_push($schedules, $data);
        }

        count($schedules) > 0 && Schedule::insert($schedules);
    }
}
