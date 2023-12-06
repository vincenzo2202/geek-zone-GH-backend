<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

 
class LikeFactory extends Factory
{
    
    public function definition(): array
    {
        return [
            'feed_id' => rand(1, 30),
            'user_id' => rand(1, 10),
        ];
    }
}
