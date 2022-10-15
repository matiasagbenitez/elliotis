<?php

namespace App\Http\Livewire\Purchases;

use App\Models\Product;
use Livewire\Component;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\VoucherTypes;
use Livewire\WithFileUploads;
use App\Models\PaymentMethods;
use App\Models\PaymentConditions;

class CreatePurchase extends Component
{
    use WithFileUploads;

    // PURCHASE PARAMETERS
    public $payment_conditions = [], $payment_methods = [], $voucher_types = [], $suppliers = [];
    public $has_order_associated = 0;

    // PRODUCTS
    public $orderProducts = [];
    public $allProducts = [];

    // CREATE FORM
    public $createForm = [
        'user_id' => 1,
        'date' => '',
        'supplier_id' => '',
        'supplier_order_id' => 1,
        'payment_condition_id' => '',
        'payment_method_id' => '',
        'voucher_type_id' => '',
        'voucher_number' => '',
        'subtotal' => 0,
        'iva' => 0,
        'total' => 0,
        'weight' => 0,
        'weight_voucher' => '',
        'observations' => '',
    ];

    // VALIDATION
    protected $rules = [
        'createForm.date' => 'required|date',
        'createForm.supplier_id' => 'required|integer|exists:suppliers,id',
        'createForm.supplier_order_id' => 'nullable|integer',
        'createForm.payment_condition_id' => 'required|integer|exists:payment_conditions,id',
        'createForm.payment_method_id' => 'required|integer|exists:payment_methods,id',
        'createForm.voucher_type_id' => 'required|integer|exists:voucher_types,id',
        'createForm.voucher_number' => 'required|numeric|unique:purchases,voucher_number',
        'createForm.subtotal' => 'nullable',
        'createForm.iva' => 'nullable',
        'createForm.total' => 'nullable',
        'createForm.weight' => 'nullable|numeric',
        'createForm.weight_voucher' => 'nullable|image|max:1024',
        'createForm.observations' => 'nullable|string',
        'orderProducts.*.product_id' => 'required',
        'orderProducts.*.quantity' => 'required|numeric|min:1'
    ];

    // MOUNT METHOD
    public function mount()
    {
        $this->payment_conditions = PaymentConditions::all();
        $this->payment_methods = PaymentMethods::all();
        $this->voucher_types = VoucherTypes::all();
        $this->suppliers = Supplier::all();

        $this->allProducts = Product::where('is_buyable', true)->orderBy('name')->get();
        $this->orderProducts = [
            ['product_id' => '', 'quantity' => 1, 'price' => 0]
        ];
    }

    // TOGGLE DIV
    public function hasOrderAssociated()
    {
        $this->has_order_associated = !$this->has_order_associated;
        $this->createForm['supplier_order_id'] = '';
    }

    // ADD PRODUCT
    public function addProduct()
    {
        $this->orderProducts[] = ['product_id' => '', 'quantity' => 1, 'price' => 0];
    }

    // REMOVE PRODUCT
    public function removeProduct($index)
    {
        unset($this->orderProducts[$index]);
        $this->orderProducts = array_values($this->orderProducts);
    }

    // SHOW PRODUCTS
    public function showProducts()
    {
        dd($this->orderProducts);
    }

    // UPDATED ORDER PRODUCTS
    public function updatedOrderProducts()
    {
        $subtotal = 0;
        foreach ($this->orderProducts as $product) {
            $subtotal += $product['price'] * $product['quantity'];
        }
        $this->createForm['subtotal'] = $subtotal;
        $this->createForm['iva'] = $subtotal * 0.21;
        $this->createForm['total'] = $subtotal * 1.21;
    }

    // CREATE PURCHASE
    public function save()
    {
        $this->validate();

        $purchase = Purchase::create($this->createForm);

        foreach ($this->orderProducts as $product) {
            $purchase->products()->attach($product['product_id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price']
            ]);
        }

        $subtotal = $purchase->products->sum(function ($product) {
            return $product->pivot->quantity * $product->pivot->price;
        });

        $iva = $subtotal * 0.21;

        $total = $subtotal + $iva;

        // Update purchase
        $purchase->update([
            'subtotal' => $subtotal,
            'iva' => $iva,
            'total' => $total
        ]);

        // Update real_stock of products in purchase considering repeated products
        foreach ($purchase->products as $product) {
            $p = Product::find($product->id);
            $p->update([
                'real_stock' => $p->real_stock + $product->pivot->quantity
            ]);

        }

        // Reset
        $this->reset(['createForm', 'orderProducts']);

        session()->flash('flash.banner', '¡La compra se ha creado correctamente!');

        return redirect()->route('admin.purchases.index');
    }

    public function render()
    {
        return view('livewire.purchases.create-purchase');
    }
}
