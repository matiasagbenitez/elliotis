<div class="container py-6">

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Registrar una nueva compra</h2>
        </div>
    </x-slot>

    <x-jet-form-section class="mb-6" submit="save">

        <x-slot name="title">
            Aclaraciones
        </x-slot>

        <x-slot name="description">
            <span>
                Lea detenidamente la información solicitada y rellene los campos requeridos para registrar una nueva compra en el sistema.
                <br><br>
                (*) Campos obligatorios.
                <br><br>
                Los campos que no son obligatorios pueden ser rellenados en cualquier momento.
            </span>
        </x-slot>

        <x-slot name="form">

            {{-- Date --}}
            <div class="col-span-6">
                <x-jet-label class="mb-2" for="date" value="Fecha de la compra (*)" />
                <x-jet-input id="date" type="date" class="mt-1 block w-full" wire:model.defer="createForm.date" />
                <x-jet-input-error for="createForm.date" class="mt-2" />
            </div>

            <div class="col-span-6">
                <h2 class="font-bold">Datos del proveedor</h2>
                <hr>
            </div>

            {{-- Supplier id --}}
            <div class="col-span-3">
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
            <div class="col-span-3">
                <x-jet-label class="mb-2" for="has_order_associated" value="¿Tiene orden asociada?" />
                <select id="" class="input-control w-full" wire:click="hasOrderAssociated">Seleccione una opción</option>
                    <option value="0">No</option>
                    <option value="1">Si</option>
                </select>
            </div>

            @if ($has_order_associated)
                {{-- Order id --}}
                <div class="col-span-6">
                    <x-jet-label class="mb-2" for="order_id" value="Orden asociada" />
                    <select id="order_id" class="input-control w-full" wire:model="createForm.supplier_order_id">
                        <option value="">Seleccione una orden</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        {{-- @foreach ($orders as $order)
                            <option value="{{ $order->id }}">{{ $order->id }}</option>
                        @endforeach --}}
                    </select>
                    <x-jet-input-error for="createForm.supplier_order_id" class="mt-2" />
                </div>
            @endif

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
                <select id="payment_condition" class="input-control w-full" wire:model.defer="createForm.payment_condition_id">
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
                <x-jet-input id="voucher_number" type="number" class="mt-1 block w-full" placeholder="Ingrese el número de comprobante" wire:model.defer="createForm.voucher_number" />
                <x-jet-input-error for="createForm.voucher_number" class="mt-2" />
            </div>

            <div class="col-span-6">
                <h2 class="font-bold">Detalle de compra</h2>
                <hr>
            </div>

            <div class="col-span-6">
                @livewire('products.add-products-component')
            </div>

            <div class="col-span-6">
                <h2 class="font-bold">Monto de la compra</h2>
                <hr>
            </div>

            {{-- Subtotal --}}
            <div class="col-span-2">
                <x-jet-label class="mb-1" for="subtotal" value="Subtotal" />
                <div class="flex items-center justify-center gap-2">
                    <span>$</span>
                    <x-jet-input id="subtotal" type="number" class="mt-1 block w-full" placeholder="Subtotal" wire:model.defer="createForm.subtotal" />
                </div>
                <x-jet-input-error for="createForm.subtotal" class="mt-2" />
            </div>

            {{-- iva --}}
            <div class="col-span-2">
                <x-jet-label class="mb-1" for="iva" value="IVA" />
                <div class="flex items-center justify-center gap-2">
                    <span>$</span>
                    <x-jet-input id="iva" type="number" class="mt-1 block w-full" placeholder="IVA" wire:model.defer="createForm.iva" />
                </div>
                <x-jet-input-error for="createForm.iva" class="mt-2" />
            </div>

            {{-- Total --}}
            <div class="col-span-2">
                <x-jet-label class="mb-1" for="total" value="Total" />
                <div class="flex items-center justify-center gap-2">
                    <span>$</span>
                    <x-jet-input id="total" type="number" class="mt-1 block w-full" placeholder="Total compra" wire:model.defer="createForm.total" />
                </div>
                <x-jet-input-error for="createForm.total" class="mt-2" />
            </div>

            <div class="col-span-6">
                <h2 class="font-bold">Información adicional</h2>
                <hr>
            </div>

            {{-- Weight --}}
            <div class="col-span-3">
                <x-jet-label class="mb-2" for="weight" value="Peso neto" />
                <x-jet-input id="weight" type="text" class="mt-1 block w-full" placeholder="Ingrese el peso neto de la compra" wire:model.defer="createForm.weight" />
                <x-jet-input-error for="createForm.weight" class="mt-2" />
            </div>

            {{-- Input type file for weight_voucher --}}
            <div class="col-span-3">
                <x-jet-label class="mb-2" for="weight_voucher" value="Comprobante de peso" />
                <input type="file" id="weight_voucher" class="input-control w-full" wire:model.defer="createForm.weight_voucher" accept="image/*">

                {{-- Image preview --}}
                @if ($createForm['weight_voucher'])
                    <div class="mt-5">
                        <img class="mt-2 w-96" src="{{ $createForm['weight_voucher']->temporaryUrl() }}" alt="Comprobante de peso">
                    </div>
                @endif

                <x-jet-input-error for="createForm.weight_voucher" class="mt-2" />
            </div>

            {{-- Observations --}}
            <div class="col-span-6">
                <x-jet-label class="mb-2" for="observations" value="Observaciones" />
                <textarea id="observations" class="input-control w-full" wire:model.defer="createForm.observations"
                    placeholder="Aquí puede escribir las observaciones que considere necesarias..."></textarea>
                <x-jet-input-error for="createForm.observations" class="mt-2" />
            </div>

        </x-slot>

        <x-slot name="actions">
            <x-jet-button class="px-6">
                Registrar compra
            </x-jet-button>
        </x-slot>

    </x-jet-form-section>

</div>
