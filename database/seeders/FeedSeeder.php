<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeedSeeder extends Seeder
{
     
    public function run(): void
    {
         DB::table('feeds')->insert([
            'title' => 'My first post',
            'content' => 'This is my first post',
            'photo' => 'https://geekshubsacademy.com/wp-content/uploads/2021/09/GeeksHubs-Academy-logo.svg',
            'user_id' => 1,
         ]);

         DB::table('feeds')->insert([
            'title' => 'My second post',
            'content' => 'This is my second post',
            'photo' => 'https://geekshubsacademy.com/wp-content/uploads/2021/09/GeeksHubs-Academy-logo.svg',
            'user_id' => 1,
         ]);

         DB::table('feeds')->insert([
            'title' => 'Hi Geeks ',
            'content' => 'I am a new user',
            'photo' => 'https://weremote.net/wp-content/uploads/2022/08/programador-concentrado-ordenador-oficina.jpg',
            'user_id' => 4,
         ]);

         DB::table('feeds')->insert([
            'title' => 'New update',
            'content' => 'Javascript is the best language',
            'photo' => 'https://img.europapress.es/fotoweb/fotonoticia_20210430172721_1200.jpg',
            'user_id' => 8,
         ]);
    }
}
