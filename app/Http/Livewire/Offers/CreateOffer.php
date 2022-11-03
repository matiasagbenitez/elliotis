<?php

namespace App\Http\Livewire\Offers;

use App\Models\Product;
use Livewire\Component;
use App\View\Components\GuestLayout;

class CreateOffer extends Component
{
    // PRODUCTS
    public $orderProducts = [];
    public $allProducts = [];

    // CREATE FORM
    public $createForm = [
        'subtotal' => 0,
        'iva' => 0,
        'total' => 0,
        'delivery_date' => '',
        'observations' => '',
    ];

    public function mount()
    {
        $this->allProducts = Product::where('is_buyable', true)->orderBy('name')->get();
        $this->orderProducts = [
            ['product_id' => '', 'quantity' => 1, 'price' => 0, 'subtotal' => '0']
        ];
    }

    public function addProduct()
    {
        if (count($this->orderProducts) == count($this->allProducts)) {
            return;
        }

        if (!empty($this->orderProducts[count($this->orderProducts) - 1]['product_id']) || count($this->orderProducts) == 0) {
            $this->orderProducts[] = ['product_id' => '', 'quantity' => 1, 'price' => 0, 'subtotal' => '0'];
        }
    }

    public function isProductInOrder($productId)
    {
        foreach ($this->orderProducts as $product) {
            if ($product['product_id'] == $productId) {
                return true;
            }
        }
        return false;
    }

    public function removeProduct($index)
    {
        unset($this->orderProducts[$index]);
        $this->orderProducts = array_values($this->orderProducts);
        $this->updatedOrderProducts();
    }

    public function updatedOrderProducts()
    {
        $subtotal = 0;

        foreach ($this->orderProducts as $index => $product) {
            $this->orderProducts[$index]['subtotal'] = number_format($product['quantity'] * $product['price'], 2, '.', '');
            $subtotal += $this->orderProducts[$index]['subtotal'];
        }

        $iva = $subtotal * 0.21;
        $total = $subtotal + $iva;

        $this->createForm['subtotal'] = number_format($subtotal, 2, '.', '');
        $this->createForm['iva'] = number_format($iva, 2, '.', '');
        $this->createForm['total'] = number_format($total, 2, '.', '');
    }

    public function render()
    {
        return view('livewire.offers.create-offer')->layout(GuestLayout::class);
    }
}
