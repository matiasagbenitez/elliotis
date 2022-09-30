<?php

namespace App\Http\Livewire\IvaConditions;

use Livewire\Component;
use App\Models\IvaCondition;

class IndexIvaConditions extends Component
{
    protected $listeners = ['delete', 'refresh' => 'render'];

    public function delete(IvaCondition $ivaCondition)
    {
        $ivaCondition->delete();
    }

    public function render()
    {
        $ivaConditions = IvaCondition::orderBy('updated_at', 'DESC')->get();
        return view('livewire.iva-conditions.index-iva-conditions', compact('ivaConditions'));
    }
}
