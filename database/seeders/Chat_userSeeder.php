<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Chat_userSeeder extends Seeder
{
     
    public function run(): void
    {
        DB::table('chat_user')->insert([
            'chat_id' => 1,
            'user_id' => 1,
        ]);
        
        DB::table('chat_user')->insert([
            'chat_id' => 1,
            'user_id' => 2,
        ]);

        DB::table('chat_user')->insert([
            'chat_id' => 2,
            'user_id' => 2,
        ]);


        DB::table('chat_user')->insert([
            'chat_id' => 2,
            'user_id' => 3,
        ]);

        DB::table('chat_user')->insert([
            'chat_id' => 3,
            'user_id' => 1,
        ]);

        DB::table('chat_user')->insert([
            'chat_id' => 3,
            'user_id' => 2,
        ]);

        DB::table('chat_user')->insert([
            'chat_id' => 3,
            'user_id' => 3,
        ]);

        DB::table('chat_user')->insert([
            'chat_id' => 4,
            'user_id' => 1,
        ]);

        DB::table('chat_user')->insert([
            'chat_id' => 4,
            'user_id' => 4,
        ]);
    }
}
