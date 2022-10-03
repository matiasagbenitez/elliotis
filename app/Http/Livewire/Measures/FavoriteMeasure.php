<?php

namespace App\Http\Livewire\Measures;

use Livewire\Component;

class FavoriteMeasure extends Component
{
    public $measure;
    public $isFavorite;

    public function mount($measure)
    {
        $this->measure = $measure;
        $this->isFavorite = $this->measure->favorite;
    }

    public function toggleFavorite()
    {
        $this->isFavorite = ! $this->isFavorite;
        $this->measure->favorite = $this->isFavorite;
        $this->measure->save();
    }

    public function render()
    {
        return view('livewire.measures.favorite-measure');
    }
}
