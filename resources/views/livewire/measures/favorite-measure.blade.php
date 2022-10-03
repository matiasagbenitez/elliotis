<div>
    <div class="mr-2">
        <button wire:click="toggleFavorite">
            @if ($isFavorite)
                <i class="fas fa-star text-yellow-400"></i>
            @else
                <i class="far fa-star"></i>
            @endif
        </button>
    </div>
</div>
