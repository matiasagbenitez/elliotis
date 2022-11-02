<div class="container py-6">

    <x-slot name="header">
        <div class="flex items-center justify-between">

            {{-- GO BACK BUTTON --}}
            <a href="{{ route('admin.tenderings.index') }}">
                <x-jet-button>
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver
                </x-jet-button>
            </a>

            {{-- PDF BUTTON --}}
            <a href="#">
                <x-jet-danger-button>
                    <i class="fas fa-file-pdf mr-2"></i>
                    Descargar PDF
                </x-jet-danger-button>
            </a>
        </div>
    </x-slot>

    {{-- Purchase detail --}}
    <div class="px-6 py-3 bg-white rounded-lg shadow">
        <span class="font-bold">Concurso #{{ $tender->id }}</span>
        <hr class="mt-1">
        <div @if (!$tender->is_active) class="grid grid-cols-2" @endif>

            {{-- DIV IZQUIERDA --}}
            <div>
                <p class="text-sm font-bold my-1">Inicio concurso:
                    {{-- <span class="font-normal"> {{ Date::parse($tender->start_date)->format('d-m-Y h:m:s') }} hs</span> --}}
                    <span class="font-normal"> {{ Date::parse($tender->start_date)->format('d-m-Y H:i') }} hs</span>
                </p>
                <div class="flex justify-between">
                    <p class="text-sm font-bold">Fin concurso:
                        <span class="font-normal">{{ Date::parse($tender->end_date)->format('d-m-Y H:i') }}
                            hs</span>
                    </p>
                    {{-- Si le fecha de fin aún no llegó o si no está inactivo, mostrar el tiempo restante --}}
                    @if ($tender->end_date > now() && $tender->is_active == 1)
                        <p class="text-sm font-bold">Tiempo restante:
                            <span class="font-normal">{{ Date::parse($tender->end_date)->diffForHumans() }}</span>
                        </p>
                    @endif
                </div>
                <p class="text-sm my-1 font-bold"> Ítems solicitados:</p>
                <ul class="list-disc list-inside ml-4">
                    {{-- Get price, quantity and subtotal for each product in pivot table --}}
                    @foreach ($tender->products as $product)
                        <li class="text-xs">{{ $product->name }} (x{{ $product->pivot->quantity }})</li>
                    @endforeach
                </ul>
                <p class="text-sm my-1 font-bold">Subtotal estimado:
                    <span class="font-normal">${{ number_format($tender->subtotal, 2, ',', '.') }}</span>
                </p>
                <p class="text-sm my-1 font-bold">Concurso analizado:
                    <span class="font-normal">{{ $tender->is_analyzed == 1 ? 'Sí' : 'No' }}</span>
                </p>
                <p class="text-sm my-1 font-bold">Oferta aceptada:
                    <span class="font-normal">{{ $tender->is_approved == 1 ? 'Sí' : 'No' }}</span>
                </p>
            </div>

            {{-- DIV DERECHA --}}
            @if (!$tender->is_active)
                <div class="flex items-center justify-center text-red-700">
                    <div class="border border-red-700 p-3 flex items-center rounded-lg">
                        <i class="fas fa-ban text-5xl mr-3"></i>
                        <div>
                            <p class="text-sm font-bold uppercase">Concurso anulado</p>
                            <p class="text-sm">
                                El concurso fue anulado por {{ $user_who_cancelled }}
                                el día {{ Date::parse($tender->cancelled_at)->format('d-m-Y') }}.
                            </p>
                            <p class="text-sm font-bold uppercase mt-2">Motivo</p>
                            <p class="text-sm">
                                {{ $tender->cancel_reason }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
