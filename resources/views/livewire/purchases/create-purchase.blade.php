<div class="max-w-5xl mx-auto bg-white p-10 my-6 rounded-lg">

    <x-slot name="header">
        <a href="{{ route('admin.purchases.index') }}">
            <x-jet-button>
                <i class="fas fa-arrow-left mr-2"></i>
                Volver
            </x-jet-button>
        </a>
    </x-slot>


    <div class="grid grid-cols-6 gap-4">
        <div class="col-span-6">
            <h2 class="font-bold text-xl text-gray-800 leading-tight mb-1 uppercase">Registrar una nueva compra</h2>
            <hr>
        </div>
        {{-- FECHA --}}
        <div class="col-span-2">
            <x-jet-label class="mb-2" for="date" value="Fecha de la compra (*)" />
            <x-jet-input id="date" type="date" class="mt-1 block w-full" wire:model.defer="createForm.date" />
            <x-jet-input-error for="createForm.date" class="mt-2" />
        </div>

        <div class="col-span-6">
            <h2 class="font-bold">Datos del proveedor</h2>
            <hr>
        </div>

        {{-- Supplier id --}}
        <div class="col-span-2">
            <x-jet-label class="mb-2" for="supplier_id" value="Proveedor (*)" />
            <select id="supplier_id" class="input-control w-full" wire:model.defer="createForm.supplier_id">
                <option value="">Seleccione un proveedor</option>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->business_name }}</option>
                @endforeach
            </select>
            <x-jet-input-error for="createForm.supplier_id" class="mt-2" />
        </div>

        {{-- Has order associated? --}}
        <div class="col-span-2">
            <x-jet-label class="mb-2" for="has_order_associated" value="¿Tiene orden asociada?" />
            <select id="" class="input-control w-full" wire:click="hasOrderAssociated">Seleccione una
                opción</option>
                <option value="0">No</option>
                <option value="1">Si</option>
            </select>
        </div>

        {{-- Order id --}}
        <div class="col-span-2">
            <x-jet-label class="mb-2" for="order_id" value="Orden asociada" />
            <select id="order_id" class="input-control w-full" wire:model="createForm.supplier_order_id"
                {{ $has_order_associated ? '' : 'disabled' }}>
                <option value="1">Seleccione una orden</option>
                <option value="2">1</option>
                <option value="3">2</option>
                {{-- @foreach ($orders as $order)
                            <option value="{{ $order->id }}">{{ $order->id }}</option>
                        @endforeach --}}
            </select>
            <x-jet-input-error for="createForm.supplier_order_id" class="mt-2" />
        </div>

        <div class="col-span-6">
            <h2 class="font-bold">Información del pago</h2>
            <hr>
        </div>

        {{-- Select for payment_methods --}}
        <div class="col-span-3">
            <x-jet-label class="mb-2" for="payment_method" value="Método de pago (*)" />
            <select id="payment_method" class="input-control w-full" wire:model.defer="createForm.payment_method_id">
                <option value="">Seleccione un método de pago</option>
                @foreach ($payment_methods as $payment_method)
                    <option value="{{ $payment_method->id }}">{{ $payment_method->name }}</option>
                @endforeach
            </select>
            <x-jet-input-error for="createForm.payment_method_id" class="mt-2" />
        </div>

        {{-- Select for payment_conditions --}}
        <div class="col-span-3">
            <x-jet-label class="mb-2" for="payment_condition" value="Condición de pago (*)" />
            <select id="payment_condition" class="input-control w-full"
                wire:model.defer="createForm.payment_condition_id">
                <option value="">Seleccione una condición de pago</option>
                @foreach ($payment_conditions as $payment_condition)
                    <option value="{{ $payment_condition->id }}">{{ $payment_condition->name }}</option>
                @endforeach
            </select>
            <x-jet-input-error for="createForm.payment_condition_id" class="mt-2" />
        </div>

        {{-- Select for voucher_type_id --}}
        <div class="col-span-3">
            <x-jet-label class="mb-2" for="voucher_type_id" value="Tipo de comprobante (*)" />
            <select id="voucher_type_id" class="input-control w-full" wire:model.defer="createForm.voucher_type_id">
                <option value="">Seleccione un tipo de comprobante</option>
                @foreach ($voucher_types as $voucher_type)
                    <option value="{{ $voucher_type->id }}">{{ $voucher_type->name }}</option>
                @endforeach
            </select>
            <x-jet-input-error for="createForm.voucher_type_id" class="mt-2" />
        </div>

        {{-- Voucher number --}}
        <div class="col-span-3">
            <x-jet-label class="mb-2" for="voucher_number" value="Número de comprobante" />
            <x-jet-input id="voucher_number" type="number" class="mt-1 block w-full"
                placeholder="Ingrese el número de comprobante" wire:model.defer="createForm.voucher_number" />
            <x-jet-input-error for="createForm.voucher_number" class="mt-2" />
        </div>

        <div class="col-span-6">
            <h2 class="font-bold">Detalle de compra</h2>
            <hr>
        </div>

        <div class="col-span-6">
            @if ($orderProducts)
                <div class="grid grid-cols-6 w-full text-center text-sm uppercase font-bold text-gray-600">
                    <div class="col-span-2 py-1">Producto</div>
                    <div class="col-span-1 py-1">Cantidad</div>
                    <div class="col-span-1 py-1">Precio unitario</div>
                    <div class="col-span-1 py-1">IVA aplicado</div>
                    <div class="col-span-1 py-1">Subtotal</div>
                </div>

                <div class="grid grid-cols-6 w-full text-center text-sm uppercase text-gray-600 gap-2 items-center">
                    @foreach ($orderProducts as $index => $orderProduct)
                        <div class="col-span-2 flex">
                            <button type="button" wire:click.prevent="removeProduct({{ $index }})">
                                <i class="fas fa-trash mx-4 hover:text-red-600" title="Eliminar producto"></i>
                            </button>
                            <select name="orderProducts[{{ $index }}][product_id]"
                                wire:model.lazy="orderProducts.{{ $index }}.product_id"
                                class="input-control w-full p-1 pl-3">
                                <option disabled value="">Seleccione un producto</option>
                                @foreach ($allProducts as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-1">
                            <x-jet-input type="number" min="1"
                                name="orderProducts[{{ $index }}][quantity]"
                                wire:model.lazy="orderProducts.{{ $index }}.quantity"
                                class="input-control w-full p-1 text-center" />
                        </div>
                        <div class="col-span-1">
                            <x-jet-input type="number" min="1"
                                name="orderProducts[{{ $index }}][price]"
                                wire:model.lazy="orderProducts.{{ $index }}.price"
                                class="input-control w-full p-1 text-center" />
                        </div>
                        <div class="col-span-1 text-xs">
                            <span>(21.00%)</span>
                        </div>
                        <div class="col-span-1 flex items-center">
                            $
                            <x-jet-input disabled readonly type="number" min="1"
                                name="orderProducts[{{ $index }}][subtotal]"
                                wire:model.lazy="orderProducts.{{ $index }}.subtotal"
                                class="input-control w-full p-1 text-center border-none shadow-none" />
                        </div>
                    @endforeach
                </div>
            @endif

            <x-jet-input-error for="orderProducts.*.product_id" class="mt-2" />


        </div>

        {{-- Subtotal --}}
        <div class="col-span-6">
            <hr>
            <div class="grid grid-cols-6 gap-2">
                <div class="col-span-4 flex justify-center items-center gap-2">
                    <div>
                        <x-jet-button type="button" wire:click.prevent="addProduct" class="px-3">
                            <i class="fas fa-plus"></i>
                        </x-jet-button>
                    </div>
                    {{-- @if ($orderProducts)
                        <div>
                            <x-jet-secondary-button type="button" wire:click="showProducts" class="px-3">
                                <i class="fas fa-cogs"></i>
                            </x-jet-secondary-button>
                        </div>
                    @endif --}}
                </div>
                <div
                    class="col-span-1 flex flex-col justify-between text-center my-1 text-sm uppercase font-bold text-gray-600">
                    <span>Subtotal</span>
                    <span>IVA</span>
                    <span>Total</span>
                </div>

                <div class="col-span-1 text-sm uppercase text-gray-600">
                    <div>
                        <div class="flex items-center">
                            <span>$</span>
                            <x-jet-input readonly disabled id="subtotal" type="number"
                                class="border-none shadow-none mt-1 p-1 w-full text-center" placeholder="Subtotal"
                                wire:model.defer="createForm.subtotal" />
                        </div>
                        <x-jet-input-error for="createForm.subtotal" class="mt-2" />
                    </div>

                    {{-- IVA --}}
                    <div>
                        <div class="flex items-center">
                            <span>$</span>
                            <x-jet-input readonly disabled id="iva" type="number"
                                class="border-none shadow-none mt-1 p-1 w-full text-center" placeholder="IVA"
                                wire:model.defer="createForm.iva" />
                        </div>
                        <x-jet-input-error for="createForm.iva" class="mt-2" />
                    </div>

                    {{-- Total --}}
                    <div>
                        <div class="flex items-center">
                            <span>$</span>
                            <x-jet-input readonly disabled id="total" type="number"
                                class="border-none shadow-none mt-1 p-1 w-full text-center" placeholder="Total compra"
                                wire:model.defer="createForm.total" />
                        </div>
                        <x-jet-input-error for="createForm.total" class="mt-2" />
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-6">
            <h2 class="font-bold">Información adicional</h2>
            <hr>
        </div>

        {{-- Weight --}}
        <div class="col-span-3">
            <div>
                <x-jet-label class="mb-2" for="weight" value="Peso neto" />
                <x-jet-input id="weight" type="number" class="mt-1 block w-full"
                    placeholder="Ingrese el peso neto de la compra" wire:model.defer="createForm.weight" />
                <x-jet-input-error for="createForm.weight" class="mt-2" />
            </div>

            {{-- Input type file for weight_voucher --}}
            <div>
                <x-jet-label class="mb-2" for="weight_voucher" value="Comprobante de peso" />
                <input type="file" id="weight_voucher" class="input-control w-full"
                    wire:model.defer="createForm.weight_voucher" accept="image/*">
                <x-jet-input-error for="createForm.weight_voucher" class="mt-2" />
            </div>
        </div>

        {{-- Image preview --}}
        @if ($createForm['weight_voucher'])
            <div class="col-span-3 items-center justify-center">
                <img class="mt-2 h-48" src="{{ $createForm['weight_voucher']->temporaryUrl() }}"
                    alt="Comprobante de peso">
            </div>
        @endif

        {{-- Observations --}}
        <div class="col-span-6">
            <x-jet-label class="mb-2" for="observations" value="Observaciones" />
            <textarea id="observations" class="input-control w-full" wire:model.defer="createForm.observations"
                placeholder="Aquí puede escribir las observaciones que considere necesarias..."></textarea>
            <x-jet-input-error for="createForm.observations" class="mt-2" />
        </div>

    </div>

    <div class="flex justify-end mt-6" wire:click="save">
        <x-jet-button class="px-6 col-span-2">
            Registrar compra
        </x-jet-button>
    </div>

</div>
