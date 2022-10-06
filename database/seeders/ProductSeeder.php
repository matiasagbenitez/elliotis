<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [

            // 10

            [
                'name' => 'Rollo de 10\'',
                'product_type_id' => 1,
                'wood_type_id' => 1,
                'code' => 'R10',
                'real_stock' => 95,
                'minimum_stock' => 30,
                'reposition' => 50,
                'iva_type_id' => 2,
                'cost' => 0.00,
                'margin' => 0.00,
                'selling_price' => 0.00,
            ],
            [
                'name' => 'Faja húmeda 1/2" x 4" x 10\'',
                'product_type_id' => 2,
                'wood_type_id' => 1,
                'code' => 'FH1/2x4x10',
                'real_stock' => 1500,
                'minimum_stock' => 1000,
                'reposition' => 500,
                'iva_type_id' => 2,
                'cost' => 0.00,
                'margin' => 0.00,
                'selling_price' => 0.00,
            ],
            [
                'name' => 'Faja seca 1/2" x 4" x 10\'',
                'product_type_id' => 3,
                'wood_type_id' => 1,
                'code' => 'FS1/2x4x10',
                'real_stock' => 2500,
                'minimum_stock' => 1000,
                'reposition' => 500,
                'iva_type_id' => 2,
                'cost' => 0.00,
                'margin' => 0.00,
                'selling_price' => 0.00,
            ],
            [
                'name' => 'Faja machimbrada 1/2" x 4" x 10\'',
                'product_type_id' => 4,
                'wood_type_id' => 1,
                'code' => 'FM1/2x4x10',
                'real_stock' => 500,
                'minimum_stock' => 100,
                'reposition' => 500,
                'iva_type_id' => 2,
                'cost' => 100.00,
                'margin' => 1.5,
                'selling_price' => 150.00,
            ],
            [
                'name' => 'Paquete grande 1/2" x 4" x 10\'',
                'product_type_id' => 5,
                'wood_type_id' => 1,
                'code' => 'PG1/2x4x10',
                'real_stock' => 5,
                'minimum_stock' => 1,
                'reposition' => 4,
                'iva_type_id' => 2,
                'cost' => 120000.00,
                'margin' => 1.5,
                'selling_price' => 180000.00,
            ],

            // 12

            [
                'name' => 'Rollo de 12\'',
                'product_type_id' => 6,
                'wood_type_id' => 1,
                'code' => 'R11',
                'real_stock' => 85,
                'minimum_stock' => 30,
                'reposition' => 50,
                'iva_type_id' => 2,
                'cost' => 0.00,
                'margin' => 0.00,
                'selling_price' => 0.00,
            ],
            [
                'name' => 'Faja húmeda 1/2" x 4" x 12\'',
                'product_type_id' => 7,
                'wood_type_id' => 1,
                'code' => 'FH1/2x4x12',
                'real_stock' => 2500,
                'minimum_stock' => 1000,
                'reposition' => 500,
                'iva_type_id' => 2,
                'cost' => 0.00,
                'margin' => 0.00,
                'selling_price' => 0.00,
            ],
            [
                'name' => 'Faja seca 1/2" x 4" x 12\'',
                'product_type_id' => 8,
                'wood_type_id' => 1,
                'code' => 'FS1/2x4x12',
                'real_stock' => 2200,
                'minimum_stock' => 1000,
                'reposition' => 500,
                'iva_type_id' => 2,
                'cost' => 0.00,
                'margin' => 0.00,
                'selling_price' => 0.00,
            ],
            [
                'name' => 'Faja machimbrada 1/2" x 4" x 12\'',
                'product_type_id' => 9,
                'wood_type_id' => 1,
                'code' => 'FM1/2x4x12',
                'real_stock' => 500,
                'minimum_stock' => 100,
                'reposition' => 500,
                'iva_type_id' => 2,
                'cost' => 100.00,
                'margin' => 1.5,
                'selling_price' => 150.00,
            ],
            [
                'name' => 'Paquete grande 1/2" x 4" x 12\'',
                'product_type_id' => 10,
                'wood_type_id' => 1,
                'code' => 'PG1/2x4x12',
                'real_stock' => 6,
                'minimum_stock' => 1,
                'reposition' => 4,
                'iva_type_id' => 2,
                'cost' => 150000.00,
                'margin' => 1.5,
                'selling_price' => 225000.00,
            ],

        ];
    }
}
