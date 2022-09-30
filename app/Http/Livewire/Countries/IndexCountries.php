<?php

namespace App\Http\Livewire\Countries;

use App\Models\Country;
use Livewire\Component;
use Livewire\WithPagination;

class IndexCountries extends Component
{
    use WithPagination;

    public $search;
    protected $listeners = ['delete', 'refresh' => 'render'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete(Country $country)
    {
        $country->delete();
    }

    public function render()
    {
        $countries = Country::where('name', 'LIKE', "%" . $this->search . "%")->paginate(6);
        return view('livewire.countries.index-countries', compact('countries'));
    }
}
