<x-guest-layout>
<h2 style="font-size:1.5rem;font-weight:800;color:#3d2210;margin:0 0 0.25rem;">Bienvenido de vuelta</h2>
<p style="font-size:0.875rem;color:#9ca3af;margin:0 0 1.75rem;">Inicia sesión en tu cuenta</p>

<x-auth-session-status class="mb-4" :status="session('status')" />

<form method="POST" action="{{ route('login') }}" style="display:flex;flex-direction:column;gap:1.25rem;">
    @csrf

    <div>
        <label for="email" style="display:block;font-size:0.8125rem;font-weight:600;color:#4a3020;margin-bottom:0.4rem;">
            Correo electrónico
        </label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
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

    <div style="display:flex;align-items:center;justify-content:space-between;">
        <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;user-select:none;">
            <input type="checkbox" name="remember" id="remember_me"
                   style="width:16px;height:16px;accent-color:#8b4d0f;border-radius:4px;">
            <span style="font-size:0.8125rem;color:#6b7280;">Recordarme</span>
        </label>
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}"
               style="font-size:0.8125rem;font-weight:600;color:#8b4d0f;text-decoration:none;"
               onmouseover="this.style.textDecoration='underline'"
               onmouseout="this.style.textDecoration='none'">
                ¿Olvidaste tu contraseña?
            </a>
        @endif
    </div>

    <button type="submit"
            style="width:100%;padding:0.9rem;border-radius:0.875rem;border:none;cursor:pointer;font-weight:700;font-size:0.9rem;color:white;background:linear-gradient(135deg,#c47a1a,#8b4d0f);box-shadow:0 3px 12px rgba(139,77,15,0.35);transition:filter 0.15s,transform 0.1s;font-family:inherit;"
            onmouseover="this.style.filter='brightness(1.1)'"
            onmouseout="this.style.filter='brightness(1)'"
            onmousedown="this.style.transform='scale(0.98)'"
            onmouseup="this.style.transform='scale(1)'">
        Iniciar sesión
    </button>

    @if (Route::has('register'))
        <p style="text-align:center;font-size:0.8125rem;color:#9ca3af;margin:0;">
            ¿No tienes cuenta?
            <a href="{{ route('planes') }}"
               style="font-weight:700;color:#8b4d0f;margin-left:0.25rem;text-decoration:none;"
               onmouseover="this.style.textDecoration='underline'"
               onmouseout="this.style.textDecoration='none'">
                Ver planes y registrarse
            </a>
        </p>
    @endif
</form>

</x-guest-layout>
