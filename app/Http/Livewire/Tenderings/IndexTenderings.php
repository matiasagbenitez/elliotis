<?php

namespace App\Http\Livewire\Tenderings;

use Livewire\Component;
use App\Models\Tendering;
use Livewire\WithPagination;

class IndexTenderings extends Component
{
    use WithPagination;
    public $query;

    public function updatedQuery()
    {
        $this->resetPage();
    }

    public function render()
    {
        switch ($this->query) {
            case 1:
                $tenderings = Tendering::where('is_active', true)->paginate(3);
                break;
            case 2:
                $tenderings = Tendering::where('is_active', false)->paginate(3);
                break;
            case 3:
                $tenderings = Tendering::where('is_active', true)->orderBy('end_date', 'asc')->paginate(3);
                break;
            case 4:
                $tenderings = Tendering::where('is_active', true)->orderBy('end_date', 'desc')->paginate(3);
                break;
            case 5:
                $tenderings = Tendering::where('is_analyzed', true)->paginate(3);
                break;
            case 6:
                $tenderings = Tendering::where('is_approved', true)->paginate(3);
                break;
            default:
                $tenderings = Tendering::paginate(3);
                break;
        }

        return view('livewire.tenderings.index-tenderings', compact('tenderings'));
    }
}
