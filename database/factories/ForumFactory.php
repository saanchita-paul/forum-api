<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ForumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'title' => $this->faker->sentence(2, false),
            'body' => $this->faker->text,
        ];
    }
}
