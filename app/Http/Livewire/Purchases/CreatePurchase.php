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
use Ramsey\Uuid\Type\Decimal;

class CreatePurchase extends Component
{
    use WithFileUploads;

    // PURCHASE PARAMETERS
    public $payment_conditions = [], $payment_methods = [], $voucher_types = [], $suppliers = [];
    public $supplier_iva_condition = '', $supplier_discriminates_iva, $has_order_associated = 0;

    // PRODUCTS
    public $orderProducts = [];
    public $allProducts = [];

    // CREATE FORM
    public $createForm = [
        'user_id' => 1,
        'date' => '',
        'supplier_id' => '',
        'supplier_order_id' => 0,
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
        $this->suppliers = Supplier::orderBy('business_name')->get();
        $this->payment_conditions = PaymentConditions::orderBy('name')->get();
        $this->payment_methods = PaymentMethods::orderBy('name')->get();
        $this->voucher_types = VoucherTypes::orderBy('name')->get();

        $this->allProducts = Product::where('is_buyable', true)->orderBy('name')->get();
        $this->orderProducts = [
            ['product_id' => '', 'quantity' => 1, 'price' => 0, 'subtotal' => '0']
        ];
    }

    // SUPPLIER IVA CONDITION
    public function updatedCreateFormSupplierId()
    {
        $this->supplier_iva_condition = Supplier::find($this->createForm['supplier_id'])->iva_condition->name ?? '';
        $this->supplier_discriminates_iva = Supplier::find($this->createForm['supplier_id'])->iva_condition->discriminate ?? null;
        $this->updatedOrderProducts();
    }

    // TOGGLE DIV
    public function updatedHasOrderAssociated()
    {
        $this->createForm['supplier_order_id'] = '';
    }

    // ADD PRODUCT
    public function addProduct()
    {
        $this->orderProducts[] = ['product_id' => '', 'quantity' => 1, 'price' => 0, 'subtotal' => 0];
    }

    // REMOVE PRODUCT
    public function removeProduct($index)
    {
        unset($this->orderProducts[$index]);
        $this->orderProducts = array_values($this->orderProducts);
        $this->updatedOrderProducts();
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
        foreach ($this->orderProducts as $index => $product) {

            // Product subtotal
            $this->orderProducts[$index]['subtotal'] = number_format($product['quantity'] * $product['price'], 2, '.', '');

            // Subtotal
            $subtotal += $product['quantity'] * $product['price'];

            // $subtotal += $product['price'] * $product['quantity'];
        }

        // Subtotal format to 2 decimals

        if($this->supplier_discriminates_iva) {
            $this->createForm['subtotal'] = number_format($subtotal, 2, '.', '');
            $this->createForm['iva'] = number_format($subtotal * 0.21, 2, '.', '');
            $this->createForm['total'] = number_format($subtotal * 1.21, 2, '.', '');
        } else {
            $this->createForm['total'] = number_format($subtotal, 2, '.', '');
        }

    }

    // CREATE PURCHASE
    public function save()
    {
        $this->validate();

        $purchase = Purchase::create($this->createForm);

        foreach ($this->orderProducts as $product) {
            $purchase->products()->attach($product['product_id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'subtotal' => $product['quantity'] * $product['price']
            ]);
        }

        $subtotal = $purchase->products->sum(function ($product) {
            return $product->pivot->subtotal;
        });

        $iva = $subtotal * 0.21;

        if ($this->supplier_discriminates_iva) {
            $purchase->update([
                'subtotal' => $subtotal,
                'iva' => $iva,
                'total' => $subtotal + $iva
            ]);
        } else {
            $purchase->update([
                'subtotal' => $subtotal,
                'iva' => 0,
                'total' => $subtotal
            ]);
        }

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
