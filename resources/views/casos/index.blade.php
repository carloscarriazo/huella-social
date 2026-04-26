<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:0.75rem;flex-wrap:wrap;">
            <h2 style="font-size:1.2rem;font-weight:700;color:#1f2937;margin:0;">Gestión de Casos</h2>
            <a href="{{ route('casos.create') }}"
               style="display:inline-flex;align-items:center;gap:0.4rem;background:#0d9488;color:white;font-size:0.8125rem;font-weight:600;padding:0.5rem 1rem;border-radius:0.5rem;text-decoration:none;box-shadow:0 1px 3px rgba(0,0,0,0.15);transition:background 0.15s;"
               onmouseover="this.style.background='#0f766e'"
               onmouseout="this.style.background='#0d9488'">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Nuevo Caso
            </a>
        </div>
    </x-slot>

    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 1.25rem;
        }
        @media (min-width: 640px) {
            .stats-grid { grid-template-columns: repeat(4, 1fr); }
        }
        .stat-card {
            background: white;
            border-radius: 0.875rem;
            border: 1px solid rgba(0,0,0,0.06);
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: 0 1px 6px rgba(0,0,0,0.06);
        }
        .stat-icon {
            width: 40px; height: 40px;
            border-radius: 0.625rem;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .data-table { width:100%; border-collapse:collapse; }
        .data-table th { padding:0.75rem 1.25rem;text-align:left;font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:#6b7280;background:#f9fafb;border-bottom:1px solid #f0f0f0; }
        .data-table td { padding:0.875rem 1.25rem;border-bottom:1px solid #f9fafb;font-size:0.875rem; }
        .data-table tr:last-child td { border-bottom:none; }
        .data-table tr:hover td { background:#fafafa; }
        .badge { display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:999px;font-size:0.72rem;font-weight:600; }
        .badge-dot { width:6px;height:6px;border-radius:50%; }
        .graf-btn {
            height:28px; border-radius:8px; display:inline-flex; align-items:center;
            justify-content:center; font-size:11px; font-weight:700; text-decoration:none;
            transition:background 0.15s, transform 0.1s; padding:0 8px; gap:4px;
            white-space:nowrap;
        }
        .graf-btn:active { transform:scale(0.95); }
        .graf-lbl { display:none; }
        @media (min-width:900px) { .graf-lbl { display:inline; } .graf-code { display:none !important; } }
        @media (max-width:639px) { .col-fecha { display:none; } }
    </style>

    @php
        $total      = $casos->count();
        $activos    = $casos->where('estado','activo')->count();
        $pendientes = $casos->where('estado','pendiente')->count();
        $cerrados   = $casos->where('estado','cerrado')->count();
    @endphp

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background:#f3f4f6;">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#6b7280" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-3-3v6m-7 4h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <p style="font-size:1.5rem;font-weight:800;color:#1f2937;margin:0;line-height:1;">{{ $total }}</p>
                <p style="font-size:0.75rem;color:#6b7280;margin:0;">Total</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#dcfce7;">
                <div style="width:12px;height:12px;border-radius:50%;background:#22c55e;"></div>
            </div>
            <div>
                <p style="font-size:1.5rem;font-weight:800;color:#15803d;margin:0;line-height:1;">{{ $activos }}</p>
                <p style="font-size:0.75rem;color:#6b7280;margin:0;">Activos</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef9c3;">
                <div style="width:12px;height:12px;border-radius:50%;background:#eab308;"></div>
            </div>
            <div>
                <p style="font-size:1.5rem;font-weight:800;color:#a16207;margin:0;line-height:1;">{{ $pendientes }}</p>
                <p style="font-size:0.75rem;color:#6b7280;margin:0;">Pendientes</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#f3f4f6;">
                <div style="width:12px;height:12px;border-radius:50%;background:#9ca3af;"></div>
            </div>
            <div>
                <p style="font-size:1.5rem;font-weight:800;color:#6b7280;margin:0;line-height:1;">{{ $cerrados }}</p>
                <p style="font-size:0.75rem;color:#6b7280;margin:0;">Cerrados</p>
            </div>
        </div>
    </div>

    <!-- Tabla -->
    <div style="background:white;border-radius:0.875rem;border:1px solid rgba(0,0,0,0.06);box-shadow:0 1px 6px rgba(0,0,0,0.06);overflow:hidden;">
        @if($casos->isEmpty())
            <div style="padding:4rem 1.5rem;text-align:center;">
                <svg width="56" height="56" fill="none" viewBox="0 0 24 24" stroke="#d1d5db" stroke-width="1.5" style="display:block;margin:0 auto 1rem;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 13h6m-3-3v6m-7 4h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p style="color:#6b7280;margin-bottom:1rem;">No tienes casos registrados aún.</p>
                <a href="{{ route('casos.create') }}"
                   style="display:inline-block;background:#0d9488;color:white;font-size:0.875rem;font-weight:600;padding:0.625rem 1.25rem;border-radius:0.5rem;text-decoration:none;">
                    Crear primer caso
                </a>
            </div>
        @else
            <div style="overflow-x:auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th class="col-fecha">Fecha</th>
                            <th>Diagramas</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($casos as $caso)
                        <tr>
                            <td>
                                <a href="{{ route('casos.show', $caso) }}"
                                   style="font-weight:600;color:#1f2937;text-decoration:none;transition:color 0.15s;"
                                   onmouseover="this.style.color='#0f766e'" onmouseout="this.style.color='#1f2937'">
                                    {{ $caso->nombre }}
                                </a>
                                @if($caso->descripcion)
                                    <p style="font-size:0.72rem;color:#9ca3af;margin:2px 0 0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:200px;">
                                        {{ $caso->descripcion }}
                                    </p>
                                @endif
                            </td>
                            <td>
                                @if($caso->tipo === 'familia')
                                    <span class="badge" style="background:#dbeafe;color:#1d4ed8;">Familia</span>
                                @else
                                    <span class="badge" style="background:#ede9fe;color:#6d28d9;">Persona</span>
                                @endif
                            </td>
                            <td>
                                @if($caso->estado === 'activo')
                                    <span class="badge" style="background:#dcfce7;color:#15803d;">
                                        <span class="badge-dot" style="background:#22c55e;"></span>Activo
                                    </span>
                                @elseif($caso->estado === 'pendiente')
                                    <span class="badge" style="background:#fef9c3;color:#a16207;">
                                        <span class="badge-dot" style="background:#eab308;"></span>Pendiente
                                    </span>
                                @else
                                    <span class="badge" style="background:#f3f4f6;color:#6b7280;">
                                        <span class="badge-dot" style="background:#9ca3af;"></span>Cerrado
                                    </span>
                                @endif
                            </td>
                            <td class="col-fecha" style="color:#6b7280;">
                                {{ $caso->created_at->format('d/m/Y') }}
                            </td>
                            <td>
                                <div style="display:flex;align-items:center;gap:5px;flex-wrap:wrap;">
                                    <a href="{{ route('graficos.show', [$caso, 'genograma']) }}"
                                       class="graf-btn" title="Familograma / Genograma"
                                       style="background:#f0fdfa;color:#0f766e;"
                                       onmouseover="this.style.background='#ccfbf1'" onmouseout="this.style.background='#f0fdfa'">
                                        <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span class="graf-lbl">Familograma</span>
                                        <span style="display:inline;" class="graf-code">F</span>
                                    </a>
                                    <a href="{{ route('graficos.show', [$caso, 'mapa_redes']) }}"
                                       class="graf-btn" title="Mapa Social"
                                       style="background:#eff6ff;color:#1d4ed8;"
                                       onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='#eff6ff'">
                                        <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                        <span class="graf-lbl">Mapa Social</span>
                                        <span style="display:inline;" class="graf-code">M</span>
                                    </a>
                                    <a href="{{ route('graficos.show', [$caso, 'ecomapa']) }}"
                                       class="graf-btn" title="Ecomapa"
                                       style="background:#fffbeb;color:#b45309;"
                                       onmouseover="this.style.background='#fde68a'" onmouseout="this.style.background='#fffbeb'">
                                        <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span class="graf-lbl">Ecomapa</span>
                                        <span style="display:inline;" class="graf-code">E</span>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <div style="display:flex;align-items:center;justify-content:flex-end;gap:0.75rem;">
                                    <a href="{{ route('casos.edit', $caso) }}"
                                       style="font-size:0.75rem;color:#6b7280;text-decoration:none;font-weight:500;"
                                       onmouseover="this.style.color='#0f766e'" onmouseout="this.style.color='#6b7280'">
                                        Editar
                                    </a>
                                    <form method="POST" action="{{ route('casos.destroy', $caso) }}"
                                          onsubmit="return confirm('¿Eliminar este caso?')" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                style="font-size:0.75rem;color:#9ca3af;background:none;border:none;cursor:pointer;font-weight:500;padding:0;font-family:inherit;"
                                                onmouseover="this.style.color='#dc2626'" onmouseout="this.style.color='#9ca3af'">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
