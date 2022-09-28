<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LocalityFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(2, true),
            'postal_code' => $this->faker->randomNumber(5, true)
        ];
    }
}
