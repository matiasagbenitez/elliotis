<?php

namespace App\Http\Livewire\ProductTypes;

use App\Models\Unity;
use App\Models\Measure;
use Livewire\Component;

class EditProductType extends Component
{
    public $isOpen = 0;
    public $product_type;

    public $editForm = ['name' => '', 'measure_id' => '', 'unity_id' => ''];
    public $measures = [], $unities = [];

    public function mount($product_type)
    {
        $this->product_type = $product_type;
        $this->editForm = [
            'name' => $product_type->name,
            'measure_id' => $product_type->measure_id,
            'unity_id' => $product_type->unity_id
        ];
        $this->measures = Measure::orderBy('favorite', 'desc')->get();
        $this->unities = Unity::all();
    }

    public function editProductType()
    {
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function update()
    {
        $this->validate([
            'editForm.name' => 'required|unique:product_types,name,' . $this->product_type->id,
            'editForm.measure_id' => 'required|exists:measures,id',
            'editForm.unity_id' => 'required|exists:unities,id'
        ]);

        $this->product_type->update([
            'name' => $this->editForm['name'],
            'measure_id' => $this->editForm['measure_id'],
            'unity_id' => $this->editForm['unity_id']
        ]);

        $this->reset('editForm');
        $this->closeModal();
        $this->emit('success', '¡El tipo de producto se ha actualizado correctamente!');
        $this->emitTo('product-types.index-product-types', 'refresh');
    }

    public function render()
    {
        return view('livewire.product-types.edit-product-type');
    }
}
