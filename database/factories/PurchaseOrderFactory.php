<?php

namespace Database\Factories;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseOrderFactory extends Factory
{
    public function definition()
    {
        $user_id = User::inRandomOrder()->first()->id;
        $supplier_id = Supplier::inRandomOrder()->first()->id;
        $registration_date = $this->faker->dateTimeBetween('-1 month', 'now');

        return [
            'user_id' => $user_id,
            'supplier_id' => $supplier_id,
            'registration_date' => $registration_date,
            'is_active' => true,
            'subtotal' => 0,
            'iva' => 0,
            'total' => 0,
            'observations' => $this->faker->text(50),
        ];
    }
}
