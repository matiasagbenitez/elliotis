<?php

namespace Database\Factories;

use App\Models\Locality;
use App\Models\IvaCondition;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    public function definition()
    {
        $iva_condition_id = IvaCondition::inRandomOrder()->first()->id;
        $locality_id = Locality::inRandomOrder()->first()->id;

        return [
            'businness_name' => $this->faker->company,
            'iva_condition_id' => $iva_condition_id,
            'cuit' => $this->faker->numberBetween(10000000000, 99999999999),
            'last_name' => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
            'adress' => $this->faker->streetAddress,
            'locality_id' => $locality_id,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'active' => $this->faker->boolean,
        ];
    }
}
