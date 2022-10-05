<?php

namespace Database\Factories;

use App\Models\Locality;
use Illuminate\Support\Str;
use App\Models\IvaCondition;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    public function definition()
    {
        $iva_condition_id = IvaCondition::inRandomOrder()->first()->id;
        $locality_id = Locality::inRandomOrder()->first()->id;
        $business_name = $this->faker->company;
        $slug = Str::slug($business_name, '-');

        return [
            'business_name' => $business_name,
            'slug' => $slug,
            'iva_condition_id' => $iva_condition_id,
            'cuit' => $this->faker->numberBetween(20, 30) . '-' . $this->faker->numberBetween(10000000, 99999999) . '-' . $this->faker->numberBetween(0, 9),
            'last_name' => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
            'adress' => $this->faker->streetAddress,
            'locality_id' => $locality_id,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'active' => $this->faker->boolean,
            'observations' => $this->faker->text(100),
        ];
    }
}
