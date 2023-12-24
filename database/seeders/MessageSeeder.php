<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder
{
    
    public function run(): void
    {
         DB::table('messages')->insert([
             'message' => 'Hello',
             'chat_id' => 1,
             'user_id' => 1,
         ]);

         DB::table('messages')->insert([
            'message' => 'Hello, how are you?',
            'chat_id' => 1,
            'user_id' => 2,
        ]);

        DB::table('messages')->insert([
            'message' => 'good, and you?',
            'chat_id' => 1,
            'user_id' => 1,
        ]);

        DB::table('messages')->insert([
            'message' => 'really good',
            'chat_id' => 1,
            'user_id' => 1,
        ]);

        DB::table('messages')->insert([
            'message' => 'GeeksHubs Academy is the best',
            'chat_id' => 2,
            'user_id' => 2,
        ]);

        DB::table('messages')->insert([
            'message' => 'i`m agree with you',
            'chat_id' => 2,
            'user_id' => 3,
        ]);

        DB::table('messages')->insert([
            'message' => 'Dani and David were the best teachers',
            'chat_id' => 2,
            'user_id' => 3,
        ]);

        DB::table('messages')->insert([
            'message' => 'they are the best',
            'chat_id' => 2,
            'user_id' => 2,
        ]);


        DB::table('messages')->insert([
            'message' => 'I have a question. Someone knows how to do a migration?',
            'chat_id' => 3,
            'user_id' => 1,
        ]);

        DB::table('messages')->insert([
            'message' => 'Yes, I know how to do it',
            'chat_id' => 3,
            'user_id' => 3,
        ]);

        DB::table('messages')->insert([
            'message' => 'Help me please',
            'chat_id' => 3,
            'user_id' => 1,
        ]);

        DB::table('messages')->insert([
            'message' => 'Sure, I will help you',
            'chat_id' => 3,
            'user_id' => 3,
        ]);

        DB::table('messages')->insert([
            'message' => 'it`s easy, tomorrow I will explain you',
            'chat_id' => 3,
            'user_id' => 2,
        ]);

        DB::table('messages')->insert([
            'message' => 'Hi, want to work with me?',
            'chat_id' => 1,
            'user_id' => 1,
        ]);

        DB::table('messages')->insert([
            'message' => 'Let`s do it',
            'chat_id' => 1,
            'user_id' => 4,
        ]);

    }
}
