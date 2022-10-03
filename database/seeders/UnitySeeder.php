<?php

namespace Database\Seeders;

use App\Models\Unity;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UnitySeeder extends Seeder
{
    public function run()
    {
        $unities = [
            [
                'name' => 'Unidad',
                'unities' => 1,
            ],
            [
                'name' => 'Paquete chico',
                'unities' => 13,
            ],
            [
                'name' => 'Paquete grande',
                'unities' => 702,
            ],
        ];

        foreach ($unities as $unity) {
            Unity::create($unity);
        }
    }
}
