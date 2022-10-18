<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use Livewire\Component;

class AddProductsComponent extends Component
{
    public $orderProducts = [];
    public $allProducts = [];

    public function mount()
    {
        $this->allProducts = Product::where('is_salable', true)->get();
        $this->orderProducts = [
            ['product_id' => '', 'quantity' => 1]
        ];
    }

    public function addProduct()
    {
        // If all products are selected, don't add more
        if (count($this->orderProducts) == count($this->allProducts)) {
            return;
        }

        if (!empty($this->orderProducts[count($this->orderProducts) - 1]['product_id'])) {
            $this->orderProducts[] = ['product_id' => '', 'quantity' => 1];
        }
    }

    public function isProductInOrder($productId)
    {
        foreach ($this->orderProducts as $orderProduct) {
            if ($orderProduct['product_id'] == $productId) {
                return true;
            }
        }

        return false;
    }

    public function removeProduct($index)
    {
        unset($this->orderProducts[$index]);
        $this->orderProducts = array_values($this->orderProducts);
    }

    public function showProducts()
    {
        dd($this->orderProducts);
    }

    public function render()
    {
        return view('livewire.products.add-products-component');
    }
}
