<?php

namespace App\Http\Livewire\Products;

use App\Models\Measure;
use App\Models\Product;
use Livewire\Component;
use App\Models\WoodType;
use App\Models\ProductName;
use Livewire\WithPagination;

class IndexProducts extends Component
{
    use WithPagination;

    public $search;
    public $product_names, $product_name;
    public $measures, $measure;
    public $wood_types, $wood_type;
    public $stock_parameter;
    public $filtersDiv = false;

    public function mount()
    {
        $this->product_names = ProductName::all();
        $this->wood_types = WoodType::all();
        $this->measures = Measure::orderBy('favorite', 'desc')->get();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleFiltersDiv()
    {
        $this->filtersDiv = !$this->filtersDiv;
        $this->resetFilters();
    }

    public function resetFilters()
    {
        $this->reset(['product_name', 'wood_type', 'measure', 'stock_parameter']);
    }

    public function updatedProductName($value)
    {
        $this->product_name = $value;
    }

    public function updatedMeasure($value)
    {
        $this->measure = $value;
    }

    public function updatedWoodType($value)
    {
        $this->wood_type = $value;
    }

    public function updatedStockParameter($value)
    {
        $this->stock_parameter = $value;
    }

    public function render()
    {
        if ($this->stock_parameter) {
            $products = Product::whereHas('productType.product_name', function ($query) {
                $query->where('name', 'LIKE', '%' . $this->product_name . '%');
            })->whereHas('productType.measure', function ($query) {
                $query->where('name', 'LIKE', '%' . $this->measure . '%');
            })->whereHas('woodType', function ($query) {
                $query->where('name', 'LIKE', '%' . $this->wood_type . '%');
            })->whereRaw('real_stock ' . $this->stock_parameter . ' minimum_stock')
            ->where('name', 'LIKE', '%' . $this->search . '%')->paginate(10);
        } else {
            $products = Product::whereHas('productType.product_name', function ($query) {
                $query->where('name', 'LIKE', '%' . $this->product_name . '%');
            })->whereHas('productType.measure', function ($query) {
                $query->where('name', 'LIKE', '%' . $this->measure . '%');
            })->whereHas('woodType', function ($query) {
                $query->where('name', 'LIKE', '%' . $this->wood_type . '%');
            })
            ->where('name', 'LIKE', '%' . $this->search . '%')->paginate(10);
        }

        return view('livewire.products.index-products', compact('products'));
    }
}
