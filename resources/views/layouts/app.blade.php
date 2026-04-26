<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Trabajo Social') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
        <style>
            *, *::before, *::after { box-sizing: border-box; }
            body { margin:0; padding:0; background:#f3e5d0; font-family:'Figtree',sans-serif; }

            @media print {
                #sidebar, .no-print { display:none!important; }
                body { background:white!important; }
                #mainContent { overflow:visible!important; padding:0!important; }
            }

            /* ── Layout raíz ── */
            #appShell {
                display: flex;
                height: 100vh;
                height: 100dvh;
                overflow: hidden;
            }

            /* ── Sidebar ── */
            #sidebar {
                display: none;           /* oculto en mobile */
                flex-direction: column;
                flex-shrink: 0;
                width: 72px;
                padding: 1rem 0;
                background: linear-gradient(180deg, #5c3a1e 0%, #3d2210 100%);
                box-shadow: 4px 0 24px rgba(0,0,0,0.35);
                z-index: 30;
                transition: width 0.3s cubic-bezier(0.4,0,0.2,1);
                overflow: hidden;
            }
            #sidebar.sb-open { width: 240px; }

            @media (min-width: 768px) {
                #sidebar { display: flex; }
                #mobileNav { display: none !important; }
            }

            /* ── Labels / items del sidebar ── */
            .nav-label {
                opacity: 0; max-width: 0; overflow: hidden;
                white-space: nowrap; display: inline-block;
                transition: opacity 0.2s ease 0.05s, max-width 0.25s ease;
            }
            #sidebar.sb-open .nav-label { opacity: 1; max-width: 180px; }

            .sb-item {
                display: flex; align-items: center; width: 100%;
                padding: 0.55rem 0; border-radius: 0.75rem;
                transition: background 0.15s, color 0.15s;
                justify-content: center;
                text-decoration: none;
                cursor: pointer;
                border: none; background: none;
                font-family: inherit;
            }
            #sidebar.sb-open .sb-item {
                justify-content: flex-start;
                padding-left: 1rem; padding-right: 0.75rem;
            }
            .sb-item:hover { background: rgba(255,255,255,0.1); color: white; }
            .sb-active    { background: rgba(255,255,255,0.22) !important; color: #fff !important; }

            .icon-menu  { display: block; }
            .icon-close { display: none; }
            #sidebar.sb-open .icon-menu  { display: none; }
            #sidebar.sb-open .icon-close { display: block; }

            .user-info {
                opacity: 0; max-width: 0; overflow: hidden; white-space: nowrap;
                transition: opacity 0.2s ease 0.05s, max-width 0.25s ease;
            }
            #sidebar.sb-open .user-info { opacity: 1; max-width: 160px; }

            /* ── Contenido principal ── */
            #mainWrapper {
                flex: 1; display: flex; flex-direction: column;
                overflow: hidden; min-width: 0;
            }
            #topBar {
                background: white;
                border-bottom: 1px solid rgba(214,198,183,0.6);
                padding: 0.75rem 1.5rem;
                flex-shrink: 0;
                box-shadow: 0 1px 4px rgba(0,0,0,0.06);
            }
            #mainContent {
                flex: 1;
                overflow: auto;
                padding: 1.25rem 1.5rem 5rem;
                background: #f3e5d0;
            }
            @media (min-width: 768px) {
                #mainContent { padding: 1.5rem 2rem 1.5rem; }
            }

            /* ── Nav móvil ── */
            #mobileNav {
                display: flex;
                position: fixed;
                bottom: 0; left: 0; right: 0;
                height: 60px;
                z-index: 50;
                align-items: center;
                justify-content: space-around;
                background: linear-gradient(90deg, #5c3a1e 0%, #3d2210 100%);
                box-shadow: 0 -2px 16px rgba(0,0,0,0.25);
            }
            .mob-item {
                display: flex; flex-direction: column; align-items: center;
                gap: 2px; padding: 0.5rem 1rem; border-radius: 0.75rem;
                text-decoration: none; transition: color 0.15s;
                font-size: 0; /* text via span */
                border: none; background: none;
                font-family: inherit; cursor: pointer;
            }
            .mob-item span { font-size: 10px; }
        </style>
    </head>
    <body>
        <div id="appShell">

            <!-- ═══════════════ SIDEBAR ═══════════════ -->
            <aside id="sidebar" class="no-print">

                <!-- Botón toggle -->
                <button id="sidebarToggle" class="sb-item"
                        style="color:rgba(255,255,255,0.65);margin:0 auto 0.5rem;width:40px;height:40px;border-radius:12px;flex-shrink:0;">
                    <svg class="icon-menu" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg class="icon-close" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>

                <!-- Logo -->
                <a href="{{ route('casos.index') }}"
                   style="display:flex;align-items:center;justify-content:center;width:44px;height:44px;border-radius:14px;margin:0 auto 1.25rem;background:rgba(255,255,255,0.18);box-shadow:0 2px 10px rgba(0,0,0,0.3);text-decoration:none;transition:transform 0.15s;flex-shrink:0;">
                    <svg width="24" height="24" viewBox="0 0 32 32" fill="none">
                        <circle cx="10" cy="11" r="7" fill="rgba(255,255,255,0.4)"/>
                        <circle cx="22" cy="11" r="7" fill="rgba(255,255,255,0.4)"/>
                        <circle cx="16" cy="22" r="7" fill="rgba(255,255,255,0.6)"/>
                    </svg>
                </a>

                <!-- Etiqueta sección -->
                <p class="nav-label"
                   style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:rgba(255,255,255,0.3);padding:0 1rem;margin:0 0 0.25rem;flex-shrink:0;">
                    Menú
                </p>

                @php
                    $isHome    = request()->routeIs('casos.index');
                    $isProfile = request()->routeIs('profile.*');
                @endphp

                <!-- Navegación -->
                <nav style="display:flex;flex-direction:column;gap:4px;flex:1;padding:0 0.5rem;">
                    <a href="{{ route('casos.index') }}"
                       class="sb-item {{ $isHome ? 'sb-active' : '' }}"
                       style="{{ $isHome ? '' : 'color:rgba(255,255,255,0.55);' }}"
                       title="Inicio">
                        <svg width="20" height="20" style="flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span class="nav-label" style="font-size:0.875rem;font-weight:600;margin-left:0.75rem;">Inicio</span>
                    </a>
                    <a href="{{ route('casos.index') }}"
                       class="sb-item"
                       style="color:rgba(255,255,255,0.55);"
                       title="Casos">
                        <svg width="20" height="20" style="flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                        </svg>
                        <span class="nav-label" style="font-size:0.875rem;font-weight:600;margin-left:0.75rem;">Casos</span>
                    </a>
                    <a href="{{ route('planes') }}"
                       class="sb-item {{ request()->routeIs('planes') ? 'sb-active' : '' }}"
                       style="{{ request()->routeIs('planes') ? '' : 'color:rgba(255,255,255,0.55);' }}"
                       title="Planes y Precios">
                        <svg width="20" height="20" style="flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                        <span class="nav-label" style="font-size:0.875rem;font-weight:600;margin-left:0.75rem;">Planes</span>
                    </a>
                    <a href="{{ route('profile.edit') }}"
                       class="sb-item {{ $isProfile ? 'sb-active' : '' }}"
                       style="{{ $isProfile ? '' : 'color:rgba(255,255,255,0.55);' }}"
                       title="Configuración">
                        <svg width="20" height="20" style="flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="nav-label" style="font-size:0.875rem;font-weight:600;margin-left:0.75rem;">Configuración</span>
                    </a>
                </nav>

                <!-- Divisor -->
                <div style="margin:0.5rem 0.75rem;border-top:1px solid rgba(255,255,255,0.1);flex-shrink:0;"></div>

                <!-- Usuario + logout -->
                <div style="padding:0 0.5rem 0.25rem;display:flex;flex-direction:column;gap:4px;flex-shrink:0;">
                    <div class="sb-item" style="pointer-events:none;cursor:default;">
                        <div style="width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:12px;background:linear-gradient(135deg,rgba(255,255,255,0.35),rgba(255,255,255,0.15));box-shadow:0 1px 4px rgba(0,0,0,0.25);flex-shrink:0;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="user-info" style="margin-left:0.75rem;min-width:0;">
                            <p style="font-size:12px;font-weight:600;color:white;margin:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ Auth::user()->name }}</p>
                            <p style="font-size:10px;color:rgba(255,255,255,0.45);margin:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="sb-item" style="color:rgba(255,255,255,0.5);width:100%;" title="Cerrar sesión">
                            <svg width="20" height="20" style="flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span class="nav-label" style="font-size:0.875rem;font-weight:600;margin-left:0.75rem;">Cerrar sesión</span>
                        </button>
                    </form>
                </div>
            </aside>

            <!-- ═══════════════ CONTENIDO ═══════════════ -->
            <div id="mainWrapper">
                @isset($header)
                <div id="topBar" class="no-print">
                    {{ $header }}
                </div>
                @endisset
                <main id="mainContent">
                    {{ $slot }}
                </main>
            </div>

        </div>

        @stack('scripts')

        <!-- ═══════════════ NAV MÓVIL ═══════════════ -->
        <nav id="mobileNav" class="no-print">
            @php
                $mobHome  = request()->routeIs('casos.index');
                $mobProf  = request()->routeIs('profile.*');
            @endphp
            <a href="{{ route('casos.index') }}" class="mob-item"
               style="color:{{ $mobHome ? 'white' : 'rgba(255,255,255,0.45)' }};">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="{{ $mobHome ? '2.5' : '2' }}">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span style="{{ $mobHome ? 'font-weight:700;' : '' }}">Inicio</span>
            </a>
            <a href="{{ route('casos.index') }}" class="mob-item" style="color:rgba(255,255,255,0.45);">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                </svg>
                <span>Casos</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="mob-item"
               style="color:{{ $mobProf ? 'white' : 'rgba(255,255,255,0.45)' }};">
                <div style="width:24px;height:24px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:11px;color:white;background:rgba(255,255,255,{{ $mobProf ? '0.45' : '0.18' }});">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <span style="{{ $mobProf ? 'font-weight:700;' : '' }}">Perfil</span>
            </a>
            <form method="POST" action="{{ route('logout') }}" style="display:flex;">
                @csrf
                <button type="submit" class="mob-item" style="color:rgba(255,255,255,0.45);">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Salir</span>
                </button>
            </form>
        </nav>

        <script>
        (function () {
            var s = document.getElementById('sidebar');
            var t = document.getElementById('sidebarToggle');
            if (!s || !t) return;
            if (localStorage.getItem('sidebarState') === 'open') s.classList.add('sb-open');
            t.addEventListener('click', function () {
                var open = s.classList.toggle('sb-open');
                localStorage.setItem('sidebarState', open ? 'open' : 'closed');
            });
        })();
        </script>
    </body>
</html>
