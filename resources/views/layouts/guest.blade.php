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
        <style>
            .guest-split { display:flex; min-height:100vh; }
            .guest-left  { display:none; flex-direction:column; justify-content:space-between;
                           padding:2.5rem; width:420px; flex-shrink:0;
                           background:linear-gradient(155deg,#6b4628 0%,#4a2e13 50%,#2e1b0a 100%); }
            .guest-right { flex:1; display:flex; flex-direction:column; align-items:center;
                           justify-content:center; padding:1.5rem; background:#fdf5ee; }
            .guest-mob   { display:flex; flex-direction:column; align-items:center; margin-bottom:2rem; }
            .guest-form  { width:100%; max-width:28rem; }
            @media (min-width:1024px) {
                .guest-left { display:flex; }
                .guest-mob  { display:none; }
                .guest-right { padding:2.5rem; }
            }
        </style>
    </head>
    <body class="font-sans antialiased" style="margin:0;padding:0;">
        <div class="guest-split">

            <!-- Panel izquierdo decorativo -->
            <div class="guest-left">
                <div style="display:flex;align-items:center;gap:0.75rem;">
                    <div style="width:42px;height:42px;border-radius:14px;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.18);box-shadow:0 2px 8px rgba(0,0,0,0.3);flex-shrink:0;">
                        <svg width="22" height="22" viewBox="0 0 32 32" fill="none">
                            <circle cx="10" cy="11" r="7" fill="rgba(255,255,255,0.4)"/>
                            <circle cx="22" cy="11" r="7" fill="rgba(255,255,255,0.4)"/>
                            <circle cx="16" cy="22" r="7" fill="rgba(255,255,255,0.6)"/>
                        </svg>
                    </div>
                    <span style="color:white;font-weight:700;font-size:1.125rem;letter-spacing:-0.01em;">Huella Social</span>
                </div>

                <div>
                    <h1 style="color:white;font-weight:800;font-size:2.1rem;line-height:1.2;letter-spacing:-0.02em;margin:0 0 0.75rem;">
                        Gestiona tus casos<br>con precisión.
                    </h1>
                    <p style="color:rgba(255,255,255,0.55);font-size:0.9rem;line-height:1.65;margin:0 0 2rem;">
                        Plataforma digital para crear familogramas, genogramas y ecomapas de forma rapida y precisa.
                    </p>
                    <div style="display:flex;flex-direction:column;gap:0.85rem;">
                        <div style="display:flex;align-items:center;gap:0.75rem;">
                            <div style="width:34px;height:34px;border-radius:10px;background:rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#fbbf24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <span style="color:rgba(255,255,255,0.72);font-size:0.875rem;">Gestión integral de casos sociales</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:0.75rem;">
                            <div style="width:34px;height:34px;border-radius:10px;background:rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#fbbf24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            </div>
                            <span style="color:rgba(255,255,255,0.72);font-size:0.875rem;">Genogramas familiares interactivos</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:0.75rem;">
                            <div style="width:34px;height:34px;border-radius:10px;background:rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#fbbf24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                            </div>
                            <span style="color:rgba(255,255,255,0.72);font-size:0.875rem;">Mapas de redes y ecomapas</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:0.75rem;">
                            <div style="width:34px;height:34px;border-radius:10px;background:rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#fbbf24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            </div>
                            <span style="color:rgba(255,255,255,0.72);font-size:0.875rem;">Exportación SVG de diagramas</span>
                        </div>
                    </div>
                </div>

                <p style="color:rgba(255,255,255,0.22);font-size:0.72rem;">
                    &copy; {{ date('Y') }} Huella Social &mdash; Todos los derechos reservados.
                </p>
            </div>

            <!-- Panel derecho (formulario) -->
            <div class="guest-right">
                <!-- Logo móvil -->
                <div class="guest-mob">
                    <div style="width:64px;height:64px;border-radius:18px;display:flex;align-items:center;justify-content:center;margin-bottom:0.75rem;box-shadow:0 4px 20px rgba(92,58,30,0.35);background:linear-gradient(135deg,#6b4428,#3d2210);">
                        <svg width="36" height="36" viewBox="0 0 32 32" fill="none">
                            <circle cx="10" cy="11" r="7" fill="rgba(255,255,255,0.4)"/>
                            <circle cx="22" cy="11" r="7" fill="rgba(255,255,255,0.4)"/>
                            <circle cx="16" cy="22" r="7" fill="rgba(255,255,255,0.6)"/>
                        </svg>
                    </div>
                    <h1 style="font-weight:700;font-size:1.25rem;color:#3d2210;margin:0 0 0.25rem;">Trabajo Social</h1>
                    <p style="font-size:0.8rem;color:#9ca3af;margin:0;">Gestión de Casos y Diagramas</p>
                </div>

                <!-- Tarjeta del formulario -->
                <div class="guest-form">
                    <div style="background:white;border-radius:1.25rem;padding:2rem 2.25rem;box-shadow:0 4px 32px rgba(92,58,30,0.1),0 1px 4px rgba(0,0,0,0.06);">
                        {{ $slot }}
                    </div>
                </div>
            </div>

        </div>
    </body>
</html>
