<?php

namespace App\Http\Livewire\Measures;

use App\Models\Measure;
use Livewire\Component;
use Livewire\WithPagination;

class IndexMeasures extends Component
{
    use WithPagination;

    public $search;

    protected $listeners = ['deleteMeasure', 'render'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteMeasure(Measure $measure)
    {
        $measure->delete();
    }

    public function render()
    {
        $measures = Measure::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('favorite', 'desc')
            ->paginate(10);
        return view('livewire.measures.index-measures', compact('measures'));
    }
}
