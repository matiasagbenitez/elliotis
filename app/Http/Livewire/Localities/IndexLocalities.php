<?php

namespace App\Http\Livewire\Localities;

use App\Models\Country;
use Livewire\Component;
use App\Models\Locality;
use Livewire\WithPagination;

class IndexLocalities extends Component
{
    use WithPagination;

    public $search;

    public $listeners = ['refresh' => 'render', 'delete'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete(Locality $locality)
    {
        $locality->delete();
    }

    public function render()
    {
        $localities = Locality::where('name', 'LIKE', "%" . $this->search . "%")
                    ->orwhere('postal_code', 'LIKE', '%' . $this->search . '%')
                    ->orderBy('updated_at', 'DESC')->paginate(6);

        return view('livewire.localities.index-localities', compact('localities'));
    }
}
