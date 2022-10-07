<?php

namespace App\Http\Livewire\ProductNames;

use Livewire\Component;
use App\Models\ProductName;

class EditProductName extends Component
{
    public $isOpen = 0;

    public $product_name, $product_name_id;

    public $editForm = [
        'name' => ''
    ];

    protected $validationAttributes = [
        'editForm.name' => 'product name'
    ];

    public function mount(ProductName $product_name)
    {
        $this->product_name = $product_name;
        $this->product_name_id = $product_name->id;
        $this->editForm['name'] = $product_name->name;
    }

    public function editProductName()
    {
        $this->openModal();
        $this->resetInputFields();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function resetInputFields()
    {
        $this->resetErrorBag();
    }

    public function update()
    {
        // Name is unique on the table
        $this->validate([
            'editForm.name' => 'required|unique:product_names,name,' . $this->product_name_id
        ]);

        $this->product_name->update([
            'name' => $this->editForm['name'],
        ]);

        $this->closeModal();
        $this->emit('success', '¡Nombre de producto actualizado con éxito!');
        $this->emitTo('product-names.index-product-names', 'refresh');
    }

    public function render()
    {
        return view('livewire.product-names.edit-product-name');
    }
}
