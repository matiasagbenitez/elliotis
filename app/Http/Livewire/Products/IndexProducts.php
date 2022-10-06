<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class IndexProducts extends Component
{
    use WithPagination;

    public $search;

    protected $listeners = ['refresh' => 'render', 'delete'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete(Product $product)
    {
        try {
            $product->delete();
            $this->emit('success', '¡Producto eliminado con éxito!');
            $this->emit('refresh');
        } catch (\Throwable $th) {
            $this->emit('error', 'Error al eliminar el producto.');
        }
    }

    public function render()
    {
        $products = Product::paginate(10);
        return view('livewire.products.index-products', compact('products'));
    }
}
