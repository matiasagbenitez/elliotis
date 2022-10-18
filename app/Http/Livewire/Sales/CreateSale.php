<?php

namespace App\Http\Livewire\Sales;

use App\Models\Sale;
use App\Models\Client;
use App\Models\Product;
use Livewire\Component;
use App\Models\Supplier;
use App\Models\VoucherTypes;
use Livewire\WithFileUploads;
use App\Models\PaymentMethods;
use App\Models\PaymentConditions;

class CreateSale extends Component
{

    use WithFileUploads;

    // SALE PARAMETERS
    public $clients = [], $payment_conditions = [], $payment_methods = [], $voucher_types = [];
    public $client_iva_condition = '', $client_discriminates_iva, $has_order_associated = 0;

    // PRODUCTS
    public $orderProducts = [];
    public $allProducts = [];

    // CREATE FORM
    public $createForm = [
        'user_id' => 1,
        'date' => '',
        'client_id' => '',
        'client_order_id' => 0,
        'payment_condition_id' => '',
        'payment_method_id' => '',
        'voucher_type_id' => '',
        'voucher_number' => '',
        'subtotal' => 0,
        'iva' => 0,
        'total' => 0,
        'observations' => '',
    ];

    // VALIDATION
    protected $rules = [
        'createForm.date' => 'required|date',
        'createForm.client_id' => 'required|integer|exists:clients,id',
        'createForm.client_order_id' => 'nullable|integer',
        'createForm.payment_condition_id' => 'required|integer|exists:payment_conditions,id',
        'createForm.payment_method_id' => 'required|integer|exists:payment_methods,id',
        'createForm.voucher_type_id' => 'required|integer|exists:voucher_types,id',
        'createForm.voucher_number' => 'required|numeric|unique:sales,voucher_number',
        'createForm.subtotal' => 'nullable',
        'createForm.iva' => 'nullable',
        'createForm.total' => 'nullable',
        'createForm.observations' => 'nullable|string',
        'orderProducts.*.product_id' => 'required',
        'orderProducts.*.quantity' => 'required|numeric|min:1',
    ];

    public function mount()
    {
        $this->clients = Client::orderBy('business_name')->get();
        $this->payment_conditions = PaymentConditions::orderBy('name')->get();
        $this->payment_methods = PaymentMethods::orderBy('name')->get();
        $this->voucher_types = VoucherTypes::orderBy('name')->get();

        $this->allProducts = Product::where('is_salable', true)->orderBy('name')->get();
        $this->orderProducts = [
            [ 'product_id' => '', 'quantity' => 1, 'price' => 0, 'subtotal' => '0']
        ];
    }

    public function updatedCreateFormClientId()
    {
        $this->client_iva_condition = Client::find($this->createForm['client_id'])->iva_condition->name ?? '';
        $this->client_discriminates_iva = Client::find($this->createForm['client_id'])->iva_condition->discriminate ?? null;
        $this->updatedOrderProducts();
    }

    public function updatedHasOrderAssociated()
    {
        $this->createForm['client_order_id'] = '';
    }

    // ADD PRODUCT
    public function addProduct()
    {
        if (count($this->orderProducts) == count($this->allProducts)) {
            return;
        }

        if (!empty($this->orderProducts[count($this->orderProducts) - 1]['product_id']) || count($this->orderProducts) == 0) {
            $this->orderProducts[] = ['product_id' => '', 'quantity' => 1, 'price' => 0, 'subtotal' => '0'];
        }
        // $this->orderProducts[] = ['product_id' => '', 'quantity' => 1, 'price' => 0, 'subtotal' => 0];
    }

    // IS PRODUCT IN ORDER
    public function isProductInOrder($product_id)
    {
        foreach ($this->orderProducts as $product) {
            if ($product['product_id'] == $product_id) {
                return true;
            }
        }
        return false;
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
            $this->orderProducts[$index]['subtotal'] = number_format($product['quantity'] * $product['price'], 2, '.', '');
            $subtotal += $this->orderProducts[$index]['subtotal'];
        }

        if ($this->client_discriminates_iva) {
            $this->createForm['subtotal'] = number_format($subtotal, 2, '.', '');
            $this->createForm['iva'] = number_format($subtotal * 0.21, 2, '.', '');
            $this->createForm['total'] = number_format($subtotal * 1.21, 2, '.', '');
        } else {
            $this->createForm['total'] = number_format($subtotal, 2, '.', '');
        }
    }

    // CREATE SALE
    public function save()
    {
        $this->validate();

        $sale = Sale::create($this->createForm);

        foreach ($this->orderProducts as $product) {
            $sale->products()->attach($product['product_id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'subtotal' => $product['quantity'] * $product['price'],
            ]);
        }

        $subtotal = $sale->products->sum(function ($product) {
            return $product->pivot->subtotal;
        });

        $iva = $subtotal * 0.21;

        if ($this->client_discriminates_iva) {
            $sale->update([
                'subtotal' => $subtotal,
                'iva' => $iva,
                'total' => $subtotal + $iva,
            ]);
        } else {
            $sale->update([
                'subtotal' => $subtotal,
                'iva' => 0,
                'total' => $subtotal,
            ]);
        }

        // UPDATE REAL STOCK
        foreach ($sale->products as $product) {
            $p = Product::find($product->id);
            $p->update([
                'real_stock' => $p->real_stock - $product->pivot->quantity,
            ]);
        }

        // Reset
        $this->reset('createForm', 'orderProducts');

        // Get last purchase->id
        $id = $sale->id;

        $message = '¡La venta se ha creado correctamente! Su ID es: ' . $id;

        session()->flash('flash.banner', $message);

        return redirect()->route('admin.sales.index');
    }

    public function render()
    {
        return view('livewire.sales.create-sale');
    }
}
