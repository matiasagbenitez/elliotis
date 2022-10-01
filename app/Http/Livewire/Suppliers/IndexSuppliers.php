<?php

namespace App\Http\Livewire\Suppliers;

use Livewire\Component;
use App\Models\Supplier;
use Livewire\WithPagination;

class IndexSuppliers extends Component
{
    use WithPagination;

    public $search;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $suppliers = Supplier::where('business_name', 'LIKE', "%" . $this->search . "%")->orderBy('updated_at', 'DESC')->paginate(6);
        return view('livewire.suppliers.index-suppliers', compact('suppliers'));
    }
}
