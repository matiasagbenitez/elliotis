<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SaleSeeder extends Seeder
{
    public function run()
    {
        Sale::factory(5)->create();

        // Associate random products to each sale
        Sale::all()->each(function ($sale) {

            for ($i=0; $i < rand(1, 4); $i++) {

                // Random product where is_sellable = true
                $product = Product::where('is_salable', true)->inRandomOrder()->first();

                $quantity = rand(3, 5);
                $price = $product->selling_price;

                $sale->products()->attach($product->id, [
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $quantity * $price
                ]);

            }

            // Subtotal
            $subtotal = $sale->products->sum(function ($product) {
                return $product->pivot->quantity * $product->pivot->price;
            });

            $sale->subtotal = $subtotal;

            if ($sale->client->iva_condition->discriminate) {
                $sale->iva = $subtotal * 0.21;
                $sale->total = $sale->subtotal + $sale->iva;
            } else {
                $sale->total = $sale->subtotal;
            }

            // Total
            $sale->save();

            // Add 1 to total_sales in client
            $client = $sale->client;
            $client->total_sales += 1;
            $client->save();

        });
    }
}