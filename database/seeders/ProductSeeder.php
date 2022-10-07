<?php

namespace Database\Seeders;

use App\Models\ProductType;
use App\Models\WoodType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [

            // 10

            [
                'name' => ProductType::find(1)->product_name->name . ' ' . ProductType::find(1)->measure->name,
                'product_type_id' => 1,
                'wood_type_id' => 1,
                'code' => 'RO' . ProductType::find(1)->measure->name,
                'real_stock' => 95,
                'minimum_stock' => 30,
                'reposition' => 50,
                'iva_type_id' => 2,
                'cost' => 0.00,
                'margin' => 0.00,
                'selling_price' => 0.00,
            ],
            [
                'name' => ProductType::find(2)->product_name->name . ' ' . ProductType::find(2)->measure->name,
                'product_type_id' => 2,
                'wood_type_id' => 1,
                'code' => 'FH' . ProductType::find(2)->measure->name,
                'real_stock' => 1500,
                'minimum_stock' => 1000,
                'reposition' => 500,
                'iva_type_id' => 2,
                'cost' => 0.00,
                'margin' => 0.00,
                'selling_price' => 0.00,
            ],
            [
                'name' => ProductType::find(3)->product_name->name . ' ' . ProductType::find(3)->measure->name,
                'product_type_id' => 3,
                'wood_type_id' => 1,
                'code' => 'FS' . ProductType::find(3)->measure->name,
                'real_stock' => 2500,
                'minimum_stock' => 1000,
                'reposition' => 500,
                'iva_type_id' => 2,
                'cost' => 0.00,
                'margin' => 0.00,
                'selling_price' => 0.00,
            ],
            [
                'name' => ProductType::find(4)->product_name->name . ' ' . ProductType::find(4)->measure->name,
                'product_type_id' => 4,
                'wood_type_id' => 1,
                'code' => 'FM' . ProductType::find(4)->measure->name,
                'real_stock' => 200,
                'minimum_stock' => 300,
                'reposition' => 500,
                'iva_type_id' => 2,
                'cost' => 100.00,
                'margin' => 1.5,
                'selling_price' => 150.00,
            ],
            [
                'name' => ProductType::find(5)->product_name->name . ' ' . ProductType::find(5)->measure->name,
                'product_type_id' => 5,
                'wood_type_id' => 1,
                'code' => 'PG' . ProductType::find(5)->measure->name,
                'real_stock' => 3,
                'minimum_stock' => 4,
                'reposition' => 4,
                'iva_type_id' => 2,
                'cost' => 120000.00,
                'margin' => 1.5,
                'selling_price' => 180000.00,
            ],

            // 12

            [
                'name' => ProductType::find(6)->product_name->name . ' ' . ProductType::find(6)->measure->name,
                'product_type_id' => 6,
                'wood_type_id' => 2,
                'code' => 'RO' . ProductType::find(6)->measure->name,
                'real_stock' => 85,
                'minimum_stock' => 30,
                'reposition' => 50,
                'iva_type_id' => 2,
                'cost' => 0.00,
                'margin' => 0.00,
                'selling_price' => 0.00,
            ],
            [
                'name' => ProductType::find(7)->product_name->name . ' ' . ProductType::find(7)->measure->name,
                'product_type_id' => 7,
                'wood_type_id' => 2,
                'code' => 'FH' . ProductType::find(7)->measure->name,
                'real_stock' => 750,
                'minimum_stock' => 1000,
                'reposition' => 500,
                'iva_type_id' => 2,
                'cost' => 0.00,
                'margin' => 0.00,
                'selling_price' => 0.00,
            ],
            [
                'name' => ProductType::find(8)->product_name->name . ' ' . ProductType::find(8)->measure->name,
                'product_type_id' => 8,
                'wood_type_id' => 2,
                'code' => 'FS' . ProductType::find(8)->measure->name,
                'real_stock' => 2200,
                'minimum_stock' => 1000,
                'reposition' => 500,
                'iva_type_id' => 2,
                'cost' => 0.00,
                'margin' => 0.00,
                'selling_price' => 0.00,
            ],
            [
                'name' => ProductType::find(9)->product_name->name . ' ' . ProductType::find(9)->measure->name,
                'product_type_id' => 9,
                'wood_type_id' => 2,
                'code' => 'FM' . ProductType::find(9)->measure->name,
                'real_stock' => 500,
                'minimum_stock' => 100,
                'reposition' => 500,
                'iva_type_id' => 2,
                'cost' => 100.00,
                'margin' => 1.5,
                'selling_price' => 150.00,
            ],
            [
                'name' => ProductType::find(10)->product_name->name . ' ' . ProductType::find(10)->measure->name,
                'product_type_id' => 10,
                'wood_type_id' => 2,
                'code' => 'PG' . ProductType::find(10)->measure->name,
                'real_stock' => 6,
                'minimum_stock' => 1,
                'reposition' => 4,
                'iva_type_id' => 2,
                'cost' => 150000.00,
                'margin' => 1.5,
                'selling_price' => 225000.00,
            ],

        ];

        foreach ($products as $product) {
            \App\Models\Product::create($product);
        }
    }
}
