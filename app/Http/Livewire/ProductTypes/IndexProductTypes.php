<?php

namespace App\Http\Livewire\ProductTypes;

use Livewire\Component;
use App\Models\ProductType;
use Livewire\WithPagination;

class IndexProductTypes extends Component
{
    use WithPagination;

    public $search;

    public $listeners = ['delete', 'refresh' => 'render'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete(ProductType $productType)
    {
        $productType->delete();
    }


    public function render()
    {
        $product_types = ProductType::where('name', 'LIKE', "%" . $this->search . "%")
                    ->orderBy('updated_at', 'DESC')->paginate(6);

        return view('livewire.product-types.index-product-types', compact('product_types'));
    }
}
