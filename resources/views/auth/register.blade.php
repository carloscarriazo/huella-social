<x-guest-layout>

@php
    $planKey = request('plan', 'gratis');
    $planes = [
        'gratis'       => ['nombre' => 'Gratis',              'precio' => '$0 — para siempre',           'color' => '#16a34a', 'bg' => '#f0fdf4', 'borde' => '#bbf7d0'],
        'basico'       => ['nombre' => 'Basico',              'precio' => '$50.000 COP/mes',             'color' => '#3b82f6', 'bg' => '#eff6ff', 'borde' => '#bfdbfe'],
        'profesional'  => ['nombre' => 'Profesional',         'precio' => '$150.000 COP/mes',            'color' => '#c47a1a', 'bg' => '#fffbeb', 'borde' => '#fde68a'],
        'universitario'=> ['nombre' => 'Licencia Universitaria', 'precio' => '$450.000 COP/mes',         'color' => '#7c3aed', 'bg' => '#f5f3ff', 'borde' => '#ddd6fe'],
    ];
    $plan = $planes[$planKey] ?? $planes['gratis'];
@endphp

{{-- Banner del plan seleccionado --}}
<div style="display:flex;align-items:center;justify-content:space-between;gap:0.75rem;padding:0.7rem 1rem;border-radius:0.875rem;border:1.5px solid {{ $plan['borde'] }};background:{{ $plan['bg'] }};margin-bottom:1.5rem;">
    <div style="display:flex;align-items:center;gap:0.6rem;">
        <div style="width:8px;height:8px;border-radius:50%;background:{{ $plan['color'] }};flex-shrink:0;"></div>
        <div>
            <p style="font-size:0.75rem;font-weight:700;color:{{ $plan['color'] }};margin:0;text-transform:uppercase;letter-spacing:0.06em;">Plan {{ $plan['nombre'] }}</p>
            <p style="font-size:0.7rem;color:#6b7280;margin:0;">{{ $plan['precio'] }}</p>
        </div>
    </div>
    <a href="{{ route('planes') }}"
       style="font-size:0.7rem;font-weight:600;color:#9ca3af;text-decoration:none;white-space:nowrap;"
       onmouseover="this.style.color='{{ $plan['color'] }}'"
       onmouseout="this.style.color='#9ca3af'">
        Cambiar plan
    </a>
</div>

<h2 style="font-size:1.5rem;font-weight:800;color:#3d2210;margin:0 0 0.25rem;">Crear cuenta</h2>
<p style="font-size:0.875rem;color:#9ca3af;margin:0 0 1.75rem;">Completa los datos para registrarte</p>

<form method="POST" action="{{ route('register') }}" style="display:flex;flex-direction:column;gap:1.1rem;">
    @csrf

    <div>
        <label for="name" style="display:block;font-size:0.8125rem;font-weight:600;color:#4a3020;margin-bottom:0.4rem;">
            Nombre completo
        </label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
               placeholder="Tu nombre completo"
               style="width:100%;box-sizing:border-box;padding:0.75rem 1rem;border-radius:0.75rem;border:1.5px solid #e5e7eb;background:#fdfaf7;color:#1e1409;font-size:0.875rem;outline:none;transition:border-color 0.15s,box-shadow 0.15s;font-family:inherit;"
               onfocus="this.style.borderColor='#f59e0b';this.style.boxShadow='0 0 0 3px rgba(245,158,11,0.12)'"
               onblur="this.style.borderColor='#e5e7eb';this.style.boxShadow='none'" />
        <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-red-600" />
    </div>

    <div>
        <label for="email" style="display:block;font-size:0.8125rem;font-weight:600;color:#4a3020;margin-bottom:0.4rem;">
            Correo electrónico
        </label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required
               placeholder="usuario@ejemplo.com"
               style="width:100%;box-sizing:border-box;padding:0.75rem 1rem;border-radius:0.75rem;border:1.5px solid #e5e7eb;background:#fdfaf7;color:#1e1409;font-size:0.875rem;outline:none;transition:border-color 0.15s,box-shadow 0.15s;font-family:inherit;"
               onfocus="this.style.borderColor='#f59e0b';this.style.boxShadow='0 0 0 3px rgba(245,158,11,0.12)'"
               onblur="this.style.borderColor='#e5e7eb';this.style.boxShadow='none'" />
        <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-600" />
    </div>

    <div>
        <label for="password" style="display:block;font-size:0.8125rem;font-weight:600;color:#4a3020;margin-bottom:0.4rem;">
            Contraseña
        </label>
        <input id="password" type="password" name="password" required
               placeholder="••••••••"
               style="width:100%;box-sizing:border-box;padding:0.75rem 1rem;border-radius:0.75rem;border:1.5px solid #e5e7eb;background:#fdfaf7;color:#1e1409;font-size:0.875rem;outline:none;transition:border-color 0.15s,box-shadow 0.15s;font-family:inherit;"
               onfocus="this.style.borderColor='#f59e0b';this.style.boxShadow='0 0 0 3px rgba(245,158,11,0.12)'"
               onblur="this.style.borderColor='#e5e7eb';this.style.boxShadow='none'" />
        <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-600" />
    </div>

    <div>
        <label for="password_confirmation" style="display:block;font-size:0.8125rem;font-weight:600;color:#4a3020;margin-bottom:0.4rem;">
            Confirmar contraseña
        </label>
        <input id="password_confirmation" type="password" name="password_confirmation" required
               placeholder="••••••••"
               style="width:100%;box-sizing:border-box;padding:0.75rem 1rem;border-radius:0.75rem;border:1.5px solid #e5e7eb;background:#fdfaf7;color:#1e1409;font-size:0.875rem;outline:none;transition:border-color 0.15s,box-shadow 0.15s;font-family:inherit;"
               onfocus="this.style.borderColor='#f59e0b';this.style.boxShadow='0 0 0 3px rgba(245,158,11,0.12)'"
               onblur="this.style.borderColor='#e5e7eb';this.style.boxShadow='none'" />
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-red-600" />
    </div>

    <button type="submit"
            style="width:100%;margin-top:0.5rem;padding:0.9rem;border-radius:0.875rem;border:none;cursor:pointer;font-weight:700;font-size:0.9rem;color:white;background:linear-gradient(135deg,#c47a1a,#8b4d0f);box-shadow:0 3px 12px rgba(139,77,15,0.35);transition:filter 0.15s,transform 0.1s;font-family:inherit;"
            onmouseover="this.style.filter='brightness(1.1)'"
            onmouseout="this.style.filter='brightness(1)'"
            onmousedown="this.style.transform='scale(0.98)'"
            onmouseup="this.style.transform='scale(1)'">
        Crear cuenta
    </button>

    <p style="text-align:center;font-size:0.8125rem;color:#9ca3af;margin:0;">
        ¿Ya tienes cuenta?
        <a href="{{ route('login') }}"
           style="font-weight:700;color:#8b4d0f;margin-left:0.25rem;text-decoration:none;"
           onmouseover="this.style.textDecoration='underline'"
           onmouseout="this.style.textDecoration='none'">
            Iniciar sesión
        </a>
    </p>
</form>

</x-guest-layout>
