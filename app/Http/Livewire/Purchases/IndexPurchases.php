<?php

namespace App\Http\Livewire\Purchases;

use App\Models\Product;
use Livewire\Component;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\VoucherTypes;
use Livewire\WithPagination;

class IndexPurchases extends Component
{
    use WithPagination;
    public $suppliers = [], $voucher_types = [];

    public $filters = [
        'supplier' => '',
        'voucherType' => '',
        'fromDate' => '',
        'toDate' => '',
    ];

    protected $listeners = ['refresh' => 'render', 'disable'];

    public function mount()
    {
        $this->suppliers = Supplier::orderBy('business_name')->get();
        $this->voucher_types = VoucherTypes::all();
    }

    public function resetFilters()
    {
        $this->filters = [
            'supplier' => '',
            'voucherType' => '',
            'fromDate' => '',
            'toDate' => '',
        ];
    }

    public function disable($id)
    {
        try {
            $purchase = Purchase::find($id);
            $purchase->is_active = false;
            $purchase->save();

            foreach ($purchase->products as $product) {
                $p = Product::find($product->id);
                $p->update([
                    'real_stock' => $p->real_stock - $product->pivot->quantity
                ]);
            }

            $this->emit('refresh');
            $this->emit('success', '¡La compra se ha anulado correctamente!');
        } catch (\Exception $e) {
            $this->emit('error', 'No es posible anular la compra.');
        }
    }

    public function render()
    {
        $purchases = Purchase::filter($this->filters)->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.purchases.index-purchases', compact('purchases'));
    }
}
