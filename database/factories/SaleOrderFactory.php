<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleOrderFactory extends Factory
{
    public function definition()
    {
        $user_id = User::inRandomOrder()->first()->id;
        $client_id = Client::inRandomOrder()->first()->id;
        $registration_date = $this->faker->dateTimeBetween('-1 month', 'now');

        return [
            'user_id' => $user_id,
            'client_id' => $client_id,
            'registration_date' => $registration_date,
            'is_active' => true,
            'subtotal' => 0,
            'iva' => 0,
            'total' => 0,
            'observations' => $this->faker->text(50),
        ];
    }
}
