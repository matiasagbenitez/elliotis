<?php

namespace App\Http\Livewire\ProductNames;

use Livewire\Component;
use App\Models\ProductName;

class CreateProductName extends Component
{
    public $isOpen = 0;

    public $createForm = ['name' => ''];

    protected $listeners = ['refresh' => 'render'];

    protected $rules = [
        'createForm.name' => 'required|string|max:255|unique:product_names,name',
    ];

    protected $validationAttributes = [
        'createForm.name' => 'name',
    ];

    public function createProductName()
    {
        $this->resetInputFields();
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

    private function resetInputFields()
    {
        $this->resetErrorBag();
        $this->createForm = ['name' => ''];
    }

    public function save()
    {
        $this->validate();

        ProductName::create($this->createForm);

        $this->emit('success', '¡Nombre de producto creado con éxito!');
        $this->closeModal();
        $this->resetInputFields();
        $this->emit('refresh');
    }

    public function render()
    {
        return view('livewire.product-names.create-product-name');
    }
}
