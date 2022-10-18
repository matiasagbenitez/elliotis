<?php

namespace App\Http\Livewire\Sales;

use App\Models\Sale;
use App\Models\Client;
use App\Models\Product;
use Livewire\Component;
use App\Models\VoucherTypes;
use Livewire\WithPagination;

class IndexSales extends Component
{

    use WithPagination;
    public $clients = [], $voucher_types = [];

    public $filters = [
        'client' => '',
        'voucherType' => '',
        'fromDate' => '',
        'toDate' => '',
    ];

    protected $listeners = ['refresh' => 'render', 'disable'];

    public function mount()
    {
        $this->clients = Client::orderBy('business_name')->get();
        $this->voucher_types = VoucherTypes::all();
    }

    public function resetFilters()
    {
        $this->filters = [
            'client' => '',
            'voucherType' => '',
            'fromDate' => '',
            'toDate' => '',
        ];
    }

    public function disable($id)
    {
        try {
            $sale = Sale::find($id);
            $sale->is_active = false;
            $sale->save();

            foreach ($sale->products as $product) {
                $p = Product::find($product->id);
                $p->update([
                    'real_stock' => $p->real_stock + $product->pivot->quantity
                ]);
            }

            // Cancelled by
            $sale->cancelled_by = auth()->user()->id;
            $sale->save();

            $this->emit('refresh');
            $this->emit('success', '¡La venta se ha anulado correctamente!');
        } catch (\Exception $e) {
            $this->emit('error', 'No es posible anular la venta.');
        }
    }

    public function render()
    {
        $sales = Sale::filter($this->filters)->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.sales.index-sales', compact('sales'));
    }
}
