<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar: {{ $caso->nombre }}
        </h2>
    </x-slot>

    <div class="py-4 max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow p-6">
            <form method="POST" action="{{ route('casos.update', $caso) }}" class="space-y-5">
                @csrf @method('PUT')

                <div>
                    <x-input-label for="nombre" value="Nombre del caso *" />
                    <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full"
                                  value="{{ old('nombre', $caso->nombre) }}" required />
                    <x-input-error :messages="$errors->get('nombre')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="tipo" value="Tipo *" />
                    <select id="tipo" name="tipo" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
                        <option value="persona" {{ old('tipo', $caso->tipo) === 'persona' ? 'selected' : '' }}>Persona</option>
                        <option value="familia" {{ old('tipo', $caso->tipo) === 'familia' ? 'selected' : '' }}>Familia</option>
                    </select>
                    <x-input-error :messages="$errors->get('tipo')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="estado" value="Estado *" />
                    <select id="estado" name="estado" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
                        <option value="activo"   {{ old('estado', $caso->estado) === 'activo'   ? 'selected' : '' }}>Activo</option>
                        <option value="pendiente"{{ old('estado', $caso->estado) === 'pendiente'? 'selected' : '' }}>Pendiente</option>
                        <option value="cerrado"  {{ old('estado', $caso->estado) === 'cerrado'  ? 'selected' : '' }}>Cerrado</option>
                    </select>
                    <x-input-error :messages="$errors->get('estado')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="descripcion" value="Descripción" />
                    <textarea id="descripcion" name="descripcion" rows="3"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">{{ old('descripcion', $caso->descripcion) }}</textarea>
                    <x-input-error :messages="$errors->get('descripcion')" class="mt-1" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="fecha_nacimiento" value="Fecha de nacimiento" />
                        <x-text-input id="fecha_nacimiento" name="fecha_nacimiento" type="date" class="mt-1 block w-full"
                                      value="{{ old('fecha_nacimiento', $caso->fecha_nacimiento?->format('Y-m-d')) }}" />
                        <x-input-error :messages="$errors->get('fecha_nacimiento')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="telefono" value="Teléfono" />
                        <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full"
                                      value="{{ old('telefono', $caso->telefono) }}" />
                        <x-input-error :messages="$errors->get('telefono')" class="mt-1" />
                    </div>
                </div>

                <div>
                    <x-input-label for="direccion" value="Dirección" />
                    <x-text-input id="direccion" name="direccion" type="text" class="mt-1 block w-full"
                                  value="{{ old('direccion', $caso->direccion) }}" />
                    <x-input-error :messages="$errors->get('direccion')" class="mt-1" />
                </div>

                <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                    <a href="{{ route('casos.show', $caso) }}" class="text-gray-600 hover:text-gray-800 text-sm">← Volver</a>
                    <x-primary-button>Actualizar Caso</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
