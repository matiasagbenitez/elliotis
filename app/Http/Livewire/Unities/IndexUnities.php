<?php

namespace App\Http\Livewire\Unities;

use App\Models\Unity;
use Livewire\Component;

class IndexUnities extends Component
{
    protected $listeners = ['delete', 'refresh' => 'render'];

    public function delete(Unity $unity)
    {
        $unity->delete();
    }

    public function render()
    {
        $unities = Unity::orderBy('updated_at', 'DESC')->get();
        return view('livewire.unities.index-unities', compact('unities'));
    }
}
