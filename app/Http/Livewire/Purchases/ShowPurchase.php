<?php

namespace App\Http\Livewire\Purchases;

use Livewire\Component;
use App\Models\Purchase;

class ShowPurchase extends Component
{
    public $purchase;

    public function mount(Purchase $purchase)
    {
        $this->purchase = $purchase;
    }

    public function render()
    {
        return view('livewire.purchases.show-purchase');
    }
}
