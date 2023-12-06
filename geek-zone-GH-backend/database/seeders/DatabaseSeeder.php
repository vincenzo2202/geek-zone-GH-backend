<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{ 
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
        ]);

        \App\Models\User::factory(7)->create();

        $this->call([
            FeedSeeder::class,
        ]);

        \App\Models\Feed::factory(30)->create();
        \App\Models\Like::factory(30)->create();
        \App\Models\Comment::factory(30)->create();

        $this->call([
            ChatSeeder::class,
        ]);

        $this->call([
            Chat_userSeeder::class,
        ]);

        $this->call([
            MessageSeeder::class,
        ]);

        $this->call([
            EventSeeder::class,
        ]);
    }

}
