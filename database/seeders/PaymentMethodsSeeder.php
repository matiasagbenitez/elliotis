<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodsSeeder extends Seeder
{
    public function run()
    {
        $payment_methods = [
            [
                'name' => 'Efectivo',
            ],
            [
                'name' => 'Transferencia',
            ],
            [
                'name' => 'Cheque',
            ],
            [
                'name' => 'Tarjeta de crédito',
            ],
            [
                'name' => 'Tarjeta de débito',
            ],
            [
                'name' => 'Mercado Pago',
            ],
            [
                'name' => 'Paypal',
            ],
            [
                'name' => 'Otro',
            ],
        ];
    }
}
