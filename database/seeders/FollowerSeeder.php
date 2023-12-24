<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FollowerSeeder extends Seeder
{
    
    public function run(): void
    {
        DB::table('followers')->insert([
            'follower_id' => 1,
            'following_id' => 2,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 1,
            'following_id' => 3,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 1,
            'following_id' => 4,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 1,
            'following_id' => 5,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 1,
            'following_id' => 6,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 1,
            'following_id' => 7,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 1,
            'following_id' => 8,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 1,
            'following_id' => 9,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 1,
            'following_id' => 10,
        ]);

        // --------------------------------------------

        DB::table('followers')->insert([
            'follower_id' => 2,
            'following_id' => 1,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 2,
            'following_id' => 3,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 2,
            'following_id' => 4,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 2,
            'following_id' => 5,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 2,
            'following_id' => 6,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 2,
            'following_id' => 7,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 2,
            'following_id' => 8,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 2,
            'following_id' => 9,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 2,
            'following_id' => 10,
        ]);

         // --------------------------------------------

         DB::table('followers')->insert([
            'follower_id' => 3,
            'following_id' => 1,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 3,
            'following_id' => 2,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 3,
            'following_id' => 4,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 3,
            'following_id' => 5,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 3,
            'following_id' => 6,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 3,
            'following_id' => 7,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 3,
            'following_id' => 8,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 3,
            'following_id' => 9,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 3,
            'following_id' => 10,
        ]);

         // --------------------------------------------

         DB::table('followers')->insert([
            'follower_id' => 4,
            'following_id' => 1,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 4,
            'following_id' => 3,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 4,
            'following_id' => 2,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 4,
            'following_id' => 5,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 4,
            'following_id' => 6,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 4,
            'following_id' => 7,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 4,
            'following_id' => 8,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 4,
            'following_id' => 9,
        ]);

        DB::table('followers')->insert([
            'follower_id' => 4,
            'following_id' => 10,
        ]);
    }
}
