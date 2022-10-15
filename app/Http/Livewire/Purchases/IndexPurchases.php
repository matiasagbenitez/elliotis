<?php

namespace App\Http\Livewire\Purchases;

use App\Models\Purchase;
use Livewire\Component;
use Livewire\WithPagination;

class IndexPurchases extends Component
{
    use WithPagination;
    public $search;

    protected $listeners = ['refresh' => 'render', 'delete'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    // public function delete(Purchase $purchase)
    // {
    //    try {
    //         $purchase->delete();
    //         $this->emit('refresh');
    //         $this->emit('success', '¡La compra se ha eliminado correctamente!');
    //     } catch (\Exception $e) {
    //         $this->emit('error', 'No es posible eliminar la compra.');
    //     }
    // }

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
