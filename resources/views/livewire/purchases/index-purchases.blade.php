<div class="container py-6">

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Compras</h2>
            {{-- @livewire('purchases.create-purchase') --}}
        </div>
    </x-slot>

    <x-responsive-table>

        <div class="px-6 py-4">
            <x-jet-input type="text" wire:model="search" class="w-full" placeholder="Filtre su búsqueda aquí..." />
        </div>

        @if ($purchases->count())
            <table class="text-gray-600 min-w-full divide-y divide-gray-200 table-fixed">
                <thead class="border-b border-gray-300 bg-gray-200">
                    <tr>
                        <th scope="col"
                            class="px-4 py-2 text-center text-md font-bold text-gray-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th scope="col"
                            class="w-1/4 px-4 py-2 text-center text-md font-bold text-gray-500 uppercase tracking-wider">
                            Fecha
                        </th>
                        <th scope="col"
                            class="w-1/4 px-4 py-2 text-center text-md font-bold text-gray-500 uppercase tracking-wider">
                            Proveedor
                        </th>
                        <th scope="col"
                            class="w-1/4 px-4 py-2 text-center text-md font-bold text-gray-500 uppercase tracking-wider">
                            N° Comprobante
                        </th>
                        <th scope="col"
                            class="w-1/4 px-4 py-2 text-center text-md font-bold text-gray-500 uppercase tracking-wider">
                            Total
                        </th>
                        <th scope="col"
                            class="px-4 py-2 text-center text-md font-bold text-gray-500 uppercase tracking-wider">
                            Acción
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($purchases as $purchase)
                        <tr class="bg-gray-50">
                            <td class="px-6 py-3">
                                <p class="text-sm uppercase">
                                    {{ $purchase->id }}
                                </p>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-center">
                                <p class="font-bold text-sm uppercase">
                                    {{ $purchase->date }}
                                </p>
                            </td>
                            <td class="px-6 py-3">
                                <p class="text-sm uppercase text-center">
                                    {{ $purchase->supplier->business_name }}
                                </p>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-center">
                                <p class="text-sm uppercase">
                                    {{ $purchase->voucher_number }}
                                </p>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-center">
                                <p class="text-sm uppercase">
                                    $ {{ $purchase->total }}
                                </p>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- @livewire('purchases.edit-purchase', ['purchase' => $purchase], key($purchase->id)) --}}
                                    <x-jet-danger-button wire:click="$emit('deletePurchase', '{{ $purchase->id }}')">
                                        <i class="fas fa-trash"></i>
                                    </x-jet-danger-button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="px-6 py-4">
                <p class="text-center font-semibold">No se encontraron registros coincidentes.</p>
            </div>
        @endif

        @if ($purchases->hasPages())
            <div class="px-6 py-3">
                {{ $purchases->links() }}
            </div>
        @endif

    </x-responsive-table>

    @push('script')
        <script>
            Livewire.on('deletePurchase', purchaseId => {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esta acción!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#1f2937',
                    cancelButtonColor: '#dc2626',
                    confirmButtonText: 'Sí, eliminar compra',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.emitTo('purchases.index-purchases', 'delete', purchaseId);

                        Livewire.on('success', message => {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                            });

                            Toast.fire({
                                icon: 'success',
                                title: message
                            });
                        });

                        Livewire.on('error', message => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: message,
                                showConfirmButton: true,
                                confirmButtonColor: '#1f2937',
                            });
                        });
                    }
                })
            });
        </script>
    @endpush

</div>
