<div class="container py-6">

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Compras</h2>
            <a href="{{ route('admin.purchases.create') }}">
                <x-jet-secondary-button>
                    Registrar nueva compra
                </x-jet-secondary-button>
            </a>
        </div>
    </x-slot>

    <x-responsive-table>

        <div class="px-6 py-4">
            <x-jet-input type="text" wire:model="search" class="w-full" placeholder="Filtre su búsqueda aquí..." />
        </div>

        @if ($purchases->count())
            <table class="text-gray-600 min-w-full divide-y divide-gray-200 table-fixed">
                <thead class="text-sm text-center text-gray-500 uppercase border-b border-gray-300 bg-gray-200">
                    <tr>
                        <th scope="col" class="w-1/5 px-4 py-2">
                            Proveedor
                        </th>
                        <th scope="col" class="w-1/5 px-4 py-2">
                            Fecha de compra
                        </th>
                        <th scope="col" class="w-1/5 px-4 py-2">
                            Tipo - N° comprobante
                        </th>
                        <th scope="col" class="w-1/5 px-4 py-2">
                            Monto total
                        </th>
                        {{-- <th scope="col" class="w-1/5 px-4 py-2">
                            Pedido asociado
                        </th> --}}
                        <th scope="col" class="w-1/5 px-4 py-2">
                            Estado
                        </th>
                        <th scope="col" class="px-4 py-2">
                            Acción
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($purchases as $purchase)
                        <tr class="bg-gray-50">
                            <td class="px-6 py-2">
                                <p class="text-sm uppercase text-center">
                                    {{ $purchase->supplier->business_name }}
                                </p>
                            </td>
                            <td class="px-6 py-2 whitespace-nowrap text-center">
                                <p class="text-sm uppercase">
                                    {{-- Format date to Y-m-d --}}
                                    {{ Date::parse($purchase->date)->format('d-m-Y') }}
                                </p>
                            </td>
                            <td class="px-6 py-2">
                                <p class="text-sm uppercase text-center">
                                    {{ $purchase->voucher_type->name }} - {{ $purchase->voucher_number }}
                                </p>
                            </td>
                            <td class="px-6 py-2 whitespace-nowrap text-center">
                                <p class="text-sm uppercase">
                                    $ {{ $purchase->total }}
                                </p>
                            </td>
                            {{-- <td class="px-6 py-2 whitespace-nowrap text-center">
                                <p class="text-sm uppercase">
                                    @if ($purchase->supplier_order_if)
                                        <span
                                            class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            POSEE
                                        </span>
                                    @else
                                        <span
                                            class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            NO POSEE
                                        </span>
                                    @endif
                                </p>
                            </td> --}}
                            <td class="px-6 py-2 whitespace-nowrap text-center">
                                <p class="text-sm uppercase">
                                    @if ($purchase->is_active == 1)
                                        <span
                                            class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            VÁLIDO
                                        </span>
                                    @else
                                        <span
                                            class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            ANULADO
                                        </span>
                                    @endif
                                </p>
                            </td>
                            <td class="px-6 py-2 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    @if ($purchase->is_active)
                                        <button title="Anular compra"
                                            wire:click="$emit('disablePurchase', '{{ $purchase->id }}')">
                                            <i class="fas fa-ban mr-1"></i>
                                        </button>
                                    @endif
                                    <a title="Ver detalle" href="{{ route('admin.purchases.show-detail', $purchase) }}">
                                        <x-jet-secondary-button>
                                            <i class="fas fa-list"></i>
                                        </x-jet-secondary-button>
                                    </a>
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
            Livewire.on('disablePurchase', purchaseId => {
                console.log(purchaseId);
                Swal.fire({
                    title: '¿Anular compra?',
                    text: "¡No podrás revertir esta acción!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#1f2937',
                    cancelButtonColor: '#dc2626',
                    confirmButtonText: 'Sí, anular compra',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emitTo('purchases.index-purchases', 'disable', purchaseId);
                        console.log('emitido');
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
