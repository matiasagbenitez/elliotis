<?php

namespace App\Http\Livewire\Offers;

use App\Models\Hash;
use Livewire\Component;
use App\View\Components\GuestLayout;

class OfferSentSuccesfully extends Component
{
    public $supplier_business_name;
    public $answered_at;
    public $tendering_end_date;

    public function mount(Hash $hash)
    {
        $this->supplier_business_name = $hash->supplier->business_name;
        $this->answered_at = $hash->answered_at;
        $this->tendering_end_date = $hash->tendering->end_date;
    }

    public function render()
    {
        return view('livewire.offers.offer-sent-succesfully')->layout(GuestLayout::class);
    }
}
