<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatSeeder extends Seeder
{
    
    public function run(): void
    {
        DB::table('chats')->insert([
            'name' => 'Chat 1',
            'user_id' => 1,
        ]);

        DB::table('chats')->insert([
            'name' => 'Chat 2',
            'user_id' => 1,
        ]);

        DB::table('chats')->insert([
            'name' => 'Chat 3',
            'user_id' => 1,
        ]);

        DB::table('chats')->insert([
            'name' => 'Chat 4',
            'user_id' => 1,
        ]);

        DB::table('chats')->insert([
            'name' => 'Chat 1',
            'user_id' => 2,
        ]);

        DB::table('chats')->insert([
            'name' => 'Chat 2',
            'user_id' => 2,
        ]);

        DB::table('chats')->insert([
            'name' => 'Chat 3',
            'user_id' => 2,
        ]);

        DB::table('chats')->insert([
            'name' => 'Chat 4',
            'user_id' => 2,
        ]);

        DB::table('chats')->insert([
            'name' => 'Chat 1',
            'user_id' => 3,
        ]);

        DB::table('chats')->insert([
            'name' => 'Chat 2',
            'user_id' => 3,
        ]);

        DB::table('chats')->insert([
            'name' => 'Chat 3',
            'user_id' => 3,
        ]);

        DB::table('chats')->insert([
            'name' => 'Chat 4',
            'user_id' => 3,
        ]);

        DB::table('chats')->insert([
            'name' => 'Chat 1',
            'user_id' => 4,
        ]);

        DB::table('chats')->insert([
            'name' => 'Chat 2',
            'user_id' => 4,
        ]);

        DB::table('chats')->insert([
            'name' => 'Chat 3',
            'user_id' => 4,
        ]);

        DB::table('chats')->insert([
            'name' => 'Chat 4',
            'user_id' => 4,
        ]);
    }
}
