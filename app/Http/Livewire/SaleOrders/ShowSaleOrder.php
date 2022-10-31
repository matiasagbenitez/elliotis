<?php

namespace App\Http\Livewire\SaleOrders;

use App\Models\User;
use Livewire\Component;
use App\Models\SaleOrder;

class ShowSaleOrder extends Component
{
    public $saleOrder;
    public $user_who_cancelled = '';

    public function mount(SaleOrder $saleOrder)
    {
        if ($saleOrder->cancelled_by) {
            $id = $saleOrder->cancelled_by;
            $this->user_who_cancelled = User::find($id)->name;
        }
        $this->saleOrder = $saleOrder;
    }

    public function render()
    {
        return view('livewire.sale-orders.show-sale-order');
    }
}
