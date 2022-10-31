<?php

namespace App\Http\Livewire\PurchaseOrders;

use App\Models\User;
use Livewire\Component;
use App\Models\PurchaseOrder;

class ShowPurchaseOrder extends Component
{
    public $purchaseOrder;
    public $user_who_cancelled = '';

    public function mount(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->cancelled_by) {
            $id = $purchaseOrder->cancelled_by;
            $this->user_who_cancelled = User::find($id)->name;
        }
        $this->purchaseOrder = $purchaseOrder;
    }

    public function render()
    {
        return view('livewire.purchase-orders.show-purchase-order');
    }
}
