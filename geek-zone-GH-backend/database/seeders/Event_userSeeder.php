<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Event_userSeeder extends Seeder
{ 
    public function run(): void
    {
        DB::table('event_user')->insert([
            'event_id' => 1,
            'user_id' => 1,
        ]);

        DB::table('event_user')->insert([
            'event_id' => 1,
            'user_id' => 2,
        ]);

        DB::table('event_user')->insert([
            'event_id' => 1,
            'user_id' => 3,
        ]);

        DB::table('event_user')->insert([
            'event_id' => 1,
            'user_id' => 4,
        ]);

        DB::table('event_user')->insert([
            'event_id' => 2,
            'user_id' => 1,
        ]);

        DB::table('event_user')->insert([
            'event_id' => 2,
            'user_id' => 5,
        ]);
        DB::table('event_user')->insert([
            'event_id' => 2,
            'user_id' => 6,
        ]);

        DB::table('event_user')->insert([
            'event_id' => 2,
            'user_id' => 7,
        ]);

        DB::table('event_user')->insert([
            'event_id' => 3,
            'user_id' => 4,
        ]);

        DB::table('event_user')->insert([
            'event_id' => 3,
            'user_id' => 6,
        ]);

        DB::table('event_user')->insert([
            'event_id' => 3,
            'user_id' => 10,
        ]);

        DB::table('event_user')->insert([
            'event_id' => 3,
            'user_id' => 9,
        ]);
    }
}
