<div>
    @if ($orderProducts)
        <table class="text-gray-600 min-w-full table-fixed" id="products_table">
            <thead>
                <tr class="text-sm uppercase py-2 text-left">
                    <th scope="col" class="w-3/4">Producto</th>
                    <th scope="col" class="w-1/4">Cantidad</th>
                    <th scope="col"></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($orderProducts as $index => $orderProduct)
                    <tr>
                        <td>
                            <select name="orderProducts[{{ $index }}][product_id]"
                                wire:model="orderProducts.{{ $index }}.product_id" class="input-control w-full">
                                <option disabled value="">Seleccione un producto</option>
                                @foreach ($allProducts as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product->name }} (${{ number_format($product->selling_price, 2) }})
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <x-jet-input type="number" min="1" name="orderProducts[{{ $index }}][quantity]"
                                wire:model="orderProducts.{{ $index }}.quantity" class="input-control w-full" />
                        </td>
                        <td>
                            <x-jet-danger-button type="button" wire:click.prevent="removeProduct({{ $index }})">
                                <i class="fas fa-trash"></i>
                            </x-jet-danger-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="flex flex-col {{ $orderProducts ? '' : 'items-center' }} gap-2 my-2">
        <div>
            <x-jet-secondary-button type="button" wire:click.prevent="addProduct">
                <i class="fas fa-plus mr-2"></i>
                Agregar producto
            </x-jet-secondary-button>
        </div>

        @if ($orderProducts)
        <div>
            <x-jet-button type="button" wire:click="showProducts">
                <i class="fas fa-save mr-2"></i>
                Guardar
            </x-jet-button>
        </div>
        @endif
    </div>

</div>
