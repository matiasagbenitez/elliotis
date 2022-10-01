<?php

namespace App\Http\Livewire\Clients;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;

class IndexClients extends Component
{
    use WithPagination;

    public $search;

    protected $listeners = ['delete' => 'disableClient'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $clients = Client::where('business_name', 'LIKE', "%" . $this->search . "%")->orderBy('updated_at', 'DESC')->paginate(6);
        return view('livewire.clients.index-clients', compact('clients'));
    }
}
