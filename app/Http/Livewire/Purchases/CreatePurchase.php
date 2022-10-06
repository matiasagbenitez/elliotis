<?php

namespace App\Http\Livewire\Purchases;

use Livewire\Component;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\VoucherTypes;
use App\Models\PaymentMethods;
use App\Models\PaymentCondition;
use App\Models\PaymentConditions;
use Livewire\WithFileUploads;

class CreatePurchase extends Component
{
    use WithFileUploads;

    public $payment_conditions = [], $payment_methods = [], $voucher_types = [], $suppliers = [];

    public $has_order_associated = 0;

    public $createForm = [
        'user_id' => '',
        'date' => '',
        'supplier_id' => '',
        'supplier_order_id' => '',
        'payment_condition_id' => '',
        'payment_method_id' => '',
        'voucher_type_id' => '',
        'voucher_number' => '',
        'subtotal' => '',
        'iva' => '',
        'total' => '',
        'weight' => '',
        'weight_voucher' => '',
        'observations' => '',
    ];

    protected $rules = [
        'createForm.date' => 'required|date',
        'createForm.supplier_id' => 'required|integer|exists:suppliers,id',
        'createForm.supplier_order_id' => 'nullable|integer',
        'createForm.payment_condition_id' => 'required|integer|exists:payment_conditions,id',
        'createForm.payment_method_id' => 'required|integer|exists:payment_methods,id',
        'createForm.voucher_type_id' => 'required|integer|exists:voucher_types,id',
        'createForm.voucher_number' => 'required|numeric|unique:purchases,voucher_number',
        'createForm.subtotal' => 'required|numeric',
        'createForm.iva' => 'required|numeric',
        'createForm.total' => 'required|numeric',
        'createForm.weight' => 'required|numeric',
        'createForm.weight_voucher' => 'nullable|image|max:1024',
        'createForm.observations' => 'nullable|string',
    ];

    protected $validationAttributes = [
        'createForm.date' => 'fecha',
        'createForm.supplier_id' => 'proveedor',
        'createForm.supplier_order_id' => 'orden de compra',
        'createForm.payment_condition_id' => 'condición de pago',
        'createForm.payment_method_id' => 'método de pago',
        'createForm.voucher_type_id' => 'tipo de comprobante',
        'createForm.voucher_number' => 'número de comprobante',
        'createForm.subtotal' => 'subtotal',
        'createForm.iva' => 'iva',
        'createForm.total' => 'total',
        'createForm.weight' => 'peso',
        'createForm.weight_voucher' => 'comprobante de peso',
        'createForm.observations' => 'observaciones',
    ];

    public function mount()
    {
        $this->payment_conditions = PaymentConditions::all();
        $this->payment_methods = PaymentMethods::all();
        $this->voucher_types = VoucherTypes::all();
        $this->suppliers = Supplier::all();
    }

    public function hasOrderAssociated()
    {
        $this->has_order_associated = !$this->has_order_associated;
        $this->createForm['supplier_order_id'] = null;
    }

    public function save()
    {
        $this->createForm['user_id'] = auth()->user()->id;
        $this->createForm['supplier_order_id'] = $this->createForm['supplier_order_id'] ?: null;

        $this->validate();

        // Save the image
        $image = $this->createForm['weight_voucher']->store('public/purchases/weight_vouchers');
        $image_name = str_replace('public/purchases/weight_vouchers/', '', $image);
        $this->createForm['weight_voucher'] = $image_name;

        Purchase::create($this->createForm);

        $this->reset('createForm');

        session()->flash('flash.banner', '¡Bien hecho! La compra se registró correctamente.');

        return redirect()->route('admin.purchases.index');
    }


    public function render()
    {
        return view('livewire.purchases.create-purchase');
    }
}
