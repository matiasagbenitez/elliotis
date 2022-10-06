<?php

namespace Database\Seeders;

use App\Models\Measure;
use App\Models\ProductType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    public function run()
    {
        $productTypes = [
            [
                'name' => 'Rollo',
                'measure_id' => 25,
                'unity_id' => 1,
            ],
            [
                'name' => 'Faja húmeda',
                'measure_id' => 21,
                'unity_id' => 1,
            ],
            [
                'name' => 'Faja seca',
                'measure_id' => 21,
                'unity_id' => 1,
            ],
            [
                'name' => 'Faja machimbrada',
                'measure_id' => 21,
                'unity_id' => 1,
            ],
            [
                'name' => 'Paquete grande machimbrado',
                'measure_id' => 21,
                'unity_id' => 3,
            ],
            [
                'name' => 'Rollo',
                'measure_id' => 27,
                'unity_id' => 1,
            ],
            [
                'name' => 'Faja húmeda',
                'measure_id' => 23,
                'unity_id' => 1,
            ],
            [
                'name' => 'Faja seca',
                'measure_id' => 23,
                'unity_id' => 1,
            ],
            [
                'name' => 'Faja machimbrada',
                'measure_id' => 23,
                'unity_id' => 1,
            ],
            [
                'name' => 'Paquete grande machimbrado',
                'measure_id' => 23,
                'unity_id' => 3,
            ],
        ];

        foreach ($productTypes as $productType) {
            $productType = ProductType::create($productType);
        }
    }
}
