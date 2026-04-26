<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div class="min-w-0">
                <a href="{{ route('casos.index') }}" class="text-sm text-teal-600 hover:text-teal-800 flex items-center gap-1 mb-1">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Casos
                </a>
                <h2 class="font-bold text-xl text-gray-800 truncate">{{ $caso->nombre }}</h2>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('casos.edit', $caso) }}"
                   class="inline-flex items-center gap-1.5 bg-white border border-gray-200 hover:border-gray-300 text-gray-700 text-sm font-medium px-3.5 py-2 rounded-lg transition shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Editar
                </a>
                <form method="POST" action="{{ route('casos.destroy', $caso) }}"
                      onsubmit="return confirm('¿Eliminar este caso permanentemente?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center gap-1.5 bg-white border border-red-200 hover:border-red-300 text-red-600 text-sm font-medium px-3.5 py-2 rounded-lg transition shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-4 space-y-5">

        <!-- Info principal -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            <!-- Datos del caso -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Información del caso</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-x-6 gap-y-4">
                    <div>
                        <p class="text-xs text-gray-400 font-medium mb-0.5">Tipo</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                            {{ $caso->tipo === 'familia' ? 'bg-blue-100 text-blue-700' : 'bg-violet-100 text-violet-700' }}">
                            {{ ucfirst($caso->tipo) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium mb-0.5">Estado</p>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold
                            {{ $caso->estado === 'activo' ? 'bg-green-100 text-green-700' :
                               ($caso->estado === 'pendiente' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-600') }}">
                            <span class="w-1.5 h-1.5 rounded-full
                                {{ $caso->estado === 'activo' ? 'bg-green-500' :
                                   ($caso->estado === 'pendiente' ? 'bg-yellow-500' : 'bg-gray-400') }}"></span>
                            {{ ucfirst($caso->estado) }}
                        </span>
                    </div>
                    @if($caso->fecha_nacimiento)
                    <div>
                        <p class="text-xs text-gray-400 font-medium mb-0.5">Fecha de nacimiento</p>
                        <p class="text-sm font-medium text-gray-700">{{ $caso->fecha_nacimiento->format('d/m/Y') }}</p>
                    </div>
                    @endif
                    @if($caso->telefono)
                    <div>
                        <p class="text-xs text-gray-400 font-medium mb-0.5">Teléfono</p>
                        <p class="text-sm font-medium text-gray-700">{{ $caso->telefono }}</p>
                    </div>
                    @endif
                    @if($caso->direccion)
                    <div class="col-span-2">
                        <p class="text-xs text-gray-400 font-medium mb-0.5">Dirección</p>
                        <p class="text-sm font-medium text-gray-700">{{ $caso->direccion }}</p>
                    </div>
                    @endif
                    <div>
                        <p class="text-xs text-gray-400 font-medium mb-0.5">Registrado</p>
                        <p class="text-sm text-gray-500">{{ $caso->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>

                @if($caso->descripcion)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-400 font-medium mb-1.5">Descripción / Observaciones</p>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $caso->descripcion }}</p>
                </div>
                @endif
            </div>

            <!-- Acceso rápido gráficos -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Herramientas Gráficas</h3>
                <div class="space-y-3">
                    <a href="{{ route('graficos.show', [$caso, 'genograma']) }}"
                       class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:border-teal-200 hover:bg-teal-50 transition group">
                        <div class="w-10 h-10 bg-teal-100 group-hover:bg-teal-200 rounded-lg flex items-center justify-center text-lg transition flex-shrink-0">🧬</div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Genograma</p>
                            <p class="text-xs text-gray-400">Estructura familiar</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-teal-500 ml-auto transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="{{ route('graficos.show', [$caso, 'mapa_redes']) }}"
                       class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:border-blue-200 hover:bg-blue-50 transition group">
                        <div class="w-10 h-10 bg-blue-100 group-hover:bg-blue-200 rounded-lg flex items-center justify-center text-lg transition flex-shrink-0">🕸️</div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Mapa Social</p>
                            <p class="text-xs text-gray-400">Red de relaciones</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-blue-500 ml-auto transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="{{ route('graficos.show', [$caso, 'ecomapa']) }}"
                       class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:border-amber-200 hover:bg-amber-50 transition group">
                        <div class="w-10 h-10 bg-amber-100 group-hover:bg-amber-200 rounded-lg flex items-center justify-center text-lg transition flex-shrink-0">🌐</div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Ecomapa</p>
                            <p class="text-xs text-gray-400">Sistemas sociales</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-amber-500 ml-auto transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
