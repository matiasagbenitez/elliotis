<?php

namespace App\Http\Livewire\Purchases;

use App\Models\Purchase;
use Livewire\Component;
use Livewire\WithPagination;

class IndexPurchases extends Component
{
    use WithPagination;
    public $search;

    protected $listeners = ['refresh' => 'render', 'disable'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function disable($id)
    {
        try {
            $purchase = Purchase::find($id);
            $purchase->is_active = false;
            $purchase->save();

            // Discount real_stock
            foreach ($purchase->products as $product) {
                $product->real_stock -= $product->pivot->quantity;
                $product->save();
            }

            $this->emit('refresh');
            $this->emit('success', '¡La compra se ha anulado correctamente!');
        } catch (\Exception $e) {
            $this->emit('error', 'No es posible anular la compra.');
        }
    }

    public function render()
    {
        // Filter by supplier business name
        $purchases = Purchase::whereHas('supplier', function ($query) {
            $query->where('business_name', 'like', '%' . $this->search . '%');
        })
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('livewire.purchases.index-purchases', compact('purchases'));
    }
}
