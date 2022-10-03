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
                'name' => 'Rollo de 10\' de largo',
                'measure_id' => 21,
                'unity_id' => 1,
            ],
            [
                'name' => 'Rollo de 12\' de largo',
                'measure_id' => 23,
                'unity_id' => 1,
            ],
        ];

        foreach ($productTypes as $productType) {
            $productType = ProductType::create($productType);
        }
    }
}
