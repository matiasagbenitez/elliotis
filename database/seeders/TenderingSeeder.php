<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Tendering;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TenderingSeeder extends Seeder
{
    public function run()
    {
        Tendering::factory(3)->create();

        // Associate random products to each tendering
        Tendering::all()->each(function ($tendering) {

            for ($i = 0; $i < rand(1, 4); $i++) {

                // Random product where is_sellable = true and is not already associated to the tendering
                $product = Product::where('is_buyable', true)
                    ->whereDoesntHave('tenderings', function ($query) use ($tendering) {
                        $query->where('tendering_id', $tendering->id);
                    })
                    ->inRandomOrder()
                    ->first();

                // $product = Product::where('is_buyable', true)->inRandomOrder()->first();

                $quantity = rand(20, 30);
                $price = $product->cost;

                $tendering->products()->attach($product->id, [
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $quantity * $price
                ]);
            }

            // Subtotal
            $subtotal = $tendering->products->sum(function ($product) {
                return $product->pivot->quantity * $product->pivot->price;
            });

            $tendering->subtotal = $subtotal;
            $tendering->iva = $subtotal * 0.21;
            $tendering->total = $tendering->subtotal + $tendering->iva;

            // Total
            $tendering->save();
        });
    }
}
