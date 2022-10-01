<?php

namespace App\Http\Livewire\Suppliers;

use Livewire\Component;
use App\Models\Locality;
use App\Models\Supplier;
use Illuminate\Support\Str;
use App\Models\IvaCondition;

class EditSupplier extends Component
{
    public $supplier;

    public $ivaConditions = [], $localities = [];

    public $editForm = [
        'business_name' => '',
        'iva_condition_id' => '',
        'cuit' => '',
        'last_name' => '',
        'first_name' => '',
        'adress' => '',
        'locality_id' => '',
        'phone' => '',
        'email' => '',
        'active' => true,
    ];

    protected $validationAttributes = [
        'editForm.business_name' => 'business name',
        'editForm.iva_condition_id' => 'IVA condition',
        'editForm.cuit' => 'cuit',
        'editForm.last_name' => 'last name',
        'editForm.first_name' => 'first name',
        'editForm.adress' => 'adress',
        'editForm.locality_id' => 'locality',
        'editForm.phone' => 'phone',
        'editForm.email' => 'email',
        'editForm.active' => 'active',
    ];

    public function mount(Supplier $supplier)
    {
        $this->supplier = $supplier;
        $this->editForm['business_name'] = $supplier->business_name;
        $this->editForm['iva_condition_id'] = $supplier->iva_condition_id;
        $this->editForm['cuit'] = $supplier->cuit;
        $this->editForm['last_name'] = $supplier->last_name;
        $this->editForm['first_name'] = $supplier->first_name;
        $this->editForm['adress'] = $supplier->adress;
        $this->editForm['locality_id'] = $supplier->locality_id;
        $this->editForm['phone'] = $supplier->phone;
        $this->editForm['email'] = $supplier->email;
        $this->editForm['active'] = $supplier->active;
        $this->ivaConditions = IvaCondition::all();
        $this->localities = Locality::orderBy('name', 'ASC')->get();
    }

    public function update()
    {
        $this->validate([
            'editForm.business_name' => 'required|string|unique:suppliers,business_name,' . $this->supplier->id,
            'editForm.iva_condition_id' => 'required|integer|exists:iva_conditions,id',
            'editForm.cuit' => 'required',
            'editForm.last_name' => 'required|string|min:3',
            'editForm.first_name' => 'required|string|min:3',
            'editForm.adress' => 'nullable',
            'editForm.locality_id' => 'required|integer|exists:localities,id',
            'editForm.phone' => 'nullable',
            'editForm.email' => 'nullable',
            'editForm.active' => 'required|boolean',
        ]);

        $this->supplier->update([
            'business_name' => $this->editForm['business_name'],
            'slug' => Str::slug($this->editForm['business_name'], '-'),
            'iva_condition_id' => $this->editForm['iva_condition_id'],
            'cuit' => $this->editForm['cuit'],
            'last_name' => $this->editForm['last_name'],
            'first_name' => $this->editForm['first_name'],
            'adress' => $this->editForm['adress'],
            'locality_id' => $this->editForm['locality_id'],
            'phone' => $this->editForm['phone'],
            'email' => $this->editForm['email'],
            'active' => $this->editForm['active'],
        ]);

        $this->reset('editForm');

        return redirect()->route('admin.suppliers.index');
    }

    public function render()
    {
        return view('livewire.suppliers.edit-supplier');
    }
}
