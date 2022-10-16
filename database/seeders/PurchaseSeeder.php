<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PurchaseSeeder extends Seeder
{
    public function run()
    {
        Purchase::factory(5)->create();

        // Associate random products to each purchase
        Purchase::all()->each(function ($purchase) {

            for ($i=0; $i < rand(1, 4); $i++) {

                // Random product where is_buyable = true
                $product = Product::where('is_buyable', true)->inRandomOrder()->first();

                $quantity = rand(20, 40);
                $price = rand(1200, 1700);

                $purchase->products()->attach($product->id, [
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $quantity * $price
                ]);

            }

            // Subtotal
            $subtotal = $purchase->products->sum(function ($product) {
                return $product->pivot->quantity * $product->pivot->price;
            });

            $purchase->subtotal = $subtotal;

            // IVA
            $purchase->iva = $purchase->subtotal * 0.21;

            // Total
            $purchase->total = $purchase->subtotal + $purchase->iva;

            $purchase->save();

        });
    }
}
