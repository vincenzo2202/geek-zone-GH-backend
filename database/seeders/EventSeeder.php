<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('events')->insert([
            'title' => 'GeeksHubs Academy Anniversary',
            'content' => 'lorem ipsum will be a big event in Valencia to celebrate the end of the course and the anniversary of GeeksHubs Academy',
            'event_date' => '2023-12-05',
            'event_time' => '12:00:00',
            'user_id' => 1,
        ]);

        DB::table('events')->insert([
            'title' => 'Dani Tarazona Master Class',
            'content' => 'This event will be a master class about Laravel imparted by Dani Tarazona who is a great developer and teacher',
            'event_date' => '2023-04-25',
            'event_time' => '18:00:00',
            'user_id' => 2,
        ]);

        DB::table('events')->insert([
            'title' => 'David Ochando Master Class',
            'content' => 'This event will be a master class about React imparted by David Ochando who is a great developer and teacher',
            'event_date' => '2023-02-05',
            'event_time' => '10:00:00',
            'user_id' => 2,
        ]);
    }
}
