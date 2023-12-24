<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

 
class FeedFactory extends Factory
{
     
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'content' => fake()->paragraph(), 
            'user_id' => rand(1, 10),
        ];
    }
}
