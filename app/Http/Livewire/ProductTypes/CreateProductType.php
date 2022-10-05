<?php

namespace App\Http\Livewire\ProductTypes;

use App\Models\Unity;
use App\Models\Measure;
use Livewire\Component;
use App\Models\ProductType;

class CreateProductType extends Component
{
    public $isOpen = 0;
    public $createForm = ['name' => '', 'measure_id' => '', 'unity_id' => ''];

    public $measures = [], $unities = [];

    protected $validationAttributes = [
        'createForm.name' => 'name',
        'createForm.measure_id' => 'measure',
        'createForm.unity_id' => 'unity'
    ];

    public function createProductType()
    {
        $this->resetInputFields();
        $this->openModal();
        $this->measures = Measure::orderBy('favorite', 'desc')->get();
        $this->unities = Unity::all();
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
        $this->createForm = ['name' => '', 'measure_id' => '', 'unity_id' => ''];
        $this->resetErrorBag();
    }

    public function save()
    {
        $this->validate([
            'createForm.name' => 'required|unique:product_types,name',
            'createForm.measure_id' => 'required|exists:measures,id',
            'createForm.unity_id' => 'required|exists:unities,id'
        ]);

        ProductType::create([
            'name' => $this->createForm['name'],
            'measure_id' => $this->createForm['measure_id'],
            'unity_id' => $this->createForm['unity_id']
        ]);

        $this->reset('createForm');
        $this->closeModal();
        $this->emit('success', '¡El tipo de producto se ha creado con éxito!');
        $this->emitTo('product-types.index-product-types', 'refresh');
    }

    public function render()
    {
        return view('livewire.product-types.create-product-type');
    }
}
