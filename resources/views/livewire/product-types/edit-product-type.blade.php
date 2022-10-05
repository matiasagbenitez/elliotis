<div>
    <x-jet-button wire:click="editProductType">
        <i class="fas fa-edit"></i>
    </x-jet-button>

    <x-jet-dialog-modal wire:model="isOpen">
        <x-slot name="title">
            Editar tipo de producto
        </x-slot>

        <x-slot name="content">

            {{-- Name --}}
            <div class="mb-4">
                <x-jet-label class="mb-2">Nombre</x-jet-label>
                <x-jet-input wire:model="editForm.name" type="text" class="w-full" placeholder="Ingrese el nombre del tipo de producto"></x-jet-input>
                <x-jet-input-error class="mt-2 text-xs font-semibold" for="editForm.name" />
            </div>

            {{-- Measure --}}
            <div class="mb-4">
                <x-jet-label class="mb-2">Medida</x-jet-label>
                <select class="input-control w-full" wire:model="editForm.measure_id">
                    <option value="" disabled selected>Seleccione la medida</option>
                    @foreach ($measures as $measure)
                        <option value="{{ $measure->id }}">{{ $measure->name }}</option>
                    @endforeach
                </select>
                <x-jet-input-error class="mt-2 text-xs font-semibold" for="editForm.measure_id" />
            </div>

            {{-- Unidad --}}
            <div class="mb-4">
                <x-jet-label class="mb-2">Unidad</x-jet-label>
                <select class="input-control w-full" wire:model="editForm.unity_id">
                    <option value="" disabled selected>Seleccione la unidad de referencia </option>
                    @foreach ($unities as $unity)
                        <option value="{{ $unity->id }}">{{ $unity->unities }} ({{ $unity->name }})</option>
                    @endforeach
                </select>
                <x-jet-input-error class="mt-2 text-xs font-semibold" for="editForm.unity_id" />
            </div>

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

@push('script')
    <script>
        Livewire.on('success', message => {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });

            Toast.fire({
                icon: 'success',
                title: message
            });
        });
    </script>
@endpush
