<div>
    <x-jet-button wire:click="editMeasure">
        <i class="fas fa-edit"></i>
    </x-jet-button>

    <x-jet-dialog-modal wire:model="isOpen">
        <x-slot name="title">
            Editar medida de producción
        </x-slot>

        <x-slot name="content">

            @if (!$hideDiv)
                {{-- Height --}}
                <div class="mb-4">
                    <x-jet-label class="mb-2">Alto (pulgadas)</x-jet-label>
                    <select class="input-control w-full" wire:model='editForm.height'>
                        {{-- Select for inches --}}
                        @foreach ($inches as $inch)
                            @if ($inch->id == $measure->height)
                                <option value="{{ $inch->id }}" selected>{{ $inch->name }}"</option>
                            @else
                                <option value="{{ $inch->id }}">{{ $inch->name }}"</option>
                            @endif
                        @endforeach
                    </select>
                    <x-jet-input-error class="mt-2 text-xs font-semibold" for="editForm.height" />
                </div>

                {{-- Width --}}
                <div class="mb-4">
                    <x-jet-label class="mb-2">Ancho (pulgadas)</x-jet-label>
                    <select class="input-control w-full" wire:model="editForm.width">
                        {{-- Select for inches --}}
                        @foreach ($inches as $inch)
                            @if ($inch->id == $measure->width)
                                <option value="{{ $inch->id }}" selected>{{ $inch->name }}"</option>
                            @else
                                <option value="{{ $inch->id }}">{{ $inch->name }}"</option>
                            @endif
                        @endforeach
                    </select>
                    <x-jet-input-error class="mt-2 text-xs font-semibold" for="editForm.width" />
                </div>
            @endif

            {{-- Length --}}
            <div class="mb-4">
                <x-jet-label class="mb-2">Largo (pies)</x-jet-label>
                <select class="input-control w-full" wire:model="editForm.length">
                    {{-- Select for feets --}}
                    @foreach ($feets as $feet)
                        @if ($feet->id == $measure->length)
                            <option value="{{ $feet->id }}" selected>{{ $feet->name }}"</option>
                        @else
                            <option value="{{ $feet->id }}">{{ $feet->name }}"</option>
                        @endif
                    @endforeach
                </select>
                <x-jet-input-error class="mt-2 text-xs font-semibold" for="editForm.length" />
            </div>

            <x-jet-input-error class="mt-2 text-xs font-semibold" for="editForm.name" />

        </x-slot>

        <x-slot name="footer">
            <div class="flex flex-end gap-3">
                <x-jet-danger-button wire:click="$set('isOpen', false)">
                    Cancelar
                </x-jet-danger-button>

                <x-jet-button wire:click="update">
                    Guardar cambios
                </x-jet-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>
</div>
