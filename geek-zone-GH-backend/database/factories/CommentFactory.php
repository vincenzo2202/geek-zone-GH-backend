<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class CommentFactory extends Factory
{

    public function definition(): array
    {
        return [
            'comment' => $this->faker->text(100),
            'feed_id' => rand(1, 30),
            'user_id' => rand(1, 10),
        ];
    }
}
