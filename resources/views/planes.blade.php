<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Planes y Precios &mdash; Huella Social</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Figtree', sans-serif; background: #fdf5ee; color: #1e1409; }

        /* ── Toggle helpers ── */
        .p-annual  { display: none; }
        .p-monthly { display: inline; }
        body.is-annual .p-monthly { display: none; }
        body.is-annual .p-annual  { display: inline; }
        body.is-annual .toggle-pill::after { transform: translateX(20px); }
        body.is-annual .lbl-mensual { color: rgba(255,255,255,0.45); font-weight: 400; }
        body.is-annual .lbl-anual   { color: white; font-weight: 700; }

        /* ── Header ── */
        .page-header {
            background: linear-gradient(135deg, #5c3a1e 0%, #3d2210 100%);
            padding: 3rem 1.5rem 4.5rem;
            text-align: center; position: relative; overflow: hidden;
        }
        .page-header::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(ellipse at 30% 50%, rgba(196,122,26,0.25) 0%, transparent 60%),
                        radial-gradient(ellipse at 70% 30%, rgba(255,255,255,0.05) 0%, transparent 50%);
        }
        .page-header .inner { position: relative; z-index: 1; max-width: 680px; margin: 0 auto; }
        .badge-top {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(196,122,26,0.3); color: #fbbf24;
            font-size: 0.75rem; font-weight: 700; letter-spacing: 0.08em;
            text-transform: uppercase; padding: 5px 14px; border-radius: 999px;
            border: 1px solid rgba(251,191,36,0.3); margin-bottom: 1rem;
        }
        .page-header h1 {
            font-size: clamp(1.75rem, 4vw, 2.75rem);
            font-weight: 800; color: white; line-height: 1.15;
            letter-spacing: -0.02em; margin-bottom: 0.75rem;
        }
        .page-header p { color: rgba(255,255,255,0.62); font-size: 1rem; line-height: 1.65; }

        /* ── Toggle billing ── */
        .billing-toggle {
            display: flex; align-items: center; justify-content: center; gap: 0.75rem;
            margin: 2rem auto 0; cursor: pointer; user-select: none;
        }
        .billing-toggle span { font-size: 0.875rem; color: rgba(255,255,255,0.55); transition: color 0.2s; }
        .lbl-mensual { color: white; font-weight: 700; }
        .toggle-pill {
            width: 44px; height: 24px; background: rgba(196,122,26,0.6);
            border-radius: 999px; position: relative; flex-shrink: 0;
        }
        .toggle-pill::after {
            content: ''; position: absolute; top: 3px; left: 3px;
            width: 18px; height: 18px; border-radius: 50%; background: #fbbf24;
            transition: transform 0.22s ease;
        }
        .save-badge {
            background: #c47a1a; color: white; font-size: 0.65rem;
            font-weight: 700; padding: 2px 8px; border-radius: 999px;
            text-transform: uppercase; letter-spacing: 0.06em;
        }

        /* ── Grid ── */
        .plans-section {
            max-width: 1200px; margin: -2.5rem auto 0; padding: 0 1.25rem 4rem;
            display: grid; grid-template-columns: 1fr; gap: 1.25rem;
        }
        @media (min-width: 640px)  { .plans-section { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 1024px) { .plans-section { grid-template-columns: repeat(4, 1fr); align-items: start; } }

        .plan-card {
            background: white; border-radius: 1.25rem;
            border: 1.5px solid rgba(0,0,0,0.07); padding: 1.75rem 1.5rem;
            box-shadow: 0 4px 20px rgba(92,58,30,0.07); position: relative;
            transition: transform 0.2s, box-shadow 0.2s; display: flex;
            flex-direction: column;
        }
        .plan-card:hover { transform: translateY(-4px); box-shadow: 0 12px 36px rgba(92,58,30,0.13); }
        .plan-card.featured {
            border-color: #c47a1a;
            box-shadow: 0 8px 40px rgba(196,122,26,0.18);
            background: linear-gradient(160deg, #fff 0%, #fffbf5 100%);
        }
        .plan-card.featured:hover { box-shadow: 0 16px 52px rgba(196,122,26,0.26); }
        .plan-card.dark {
            background: linear-gradient(155deg, #4a2e13, #2e1b0a);
            border-color: transparent;
            box-shadow: 0 8px 40px rgba(46,27,10,0.3);
        }
        .plan-card.dark:hover { box-shadow: 0 16px 52px rgba(46,27,10,0.4); }

        .popular-badge {
            position: absolute; top: -13px; left: 50%; transform: translateX(-50%);
            background: linear-gradient(135deg, #c47a1a, #8b4d0f);
            color: white; font-size: 0.7rem; font-weight: 700; letter-spacing: 0.08em;
            text-transform: uppercase; padding: 4px 16px; border-radius: 999px;
            box-shadow: 0 2px 10px rgba(139,77,15,0.4); white-space: nowrap;
        }

        .plan-icon {
            width: 44px; height: 44px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center; margin-bottom: 0.875rem;
        }
        .plan-name { font-size: 0.775rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.3rem; }
        .plan-desc { font-size: 0.8125rem; color: #6b7280; line-height: 1.55; margin-bottom: 1.25rem; }
        .plan-card.dark .plan-desc { color: rgba(255,255,255,0.5); }

        .price-block { margin-bottom: 1.5rem; }
        .price-free  { font-size: 2rem; font-weight: 800; color: #16a34a; line-height: 1; }
        .price-amount { font-size: 1.9rem; font-weight: 800; line-height: 1; letter-spacing: -0.03em; }
        .price-suffix { font-size: 0.875rem; font-weight: 600; }
        .price-period { font-size: 0.775rem; color: #9ca3af; margin-top: 4px; }
        .price-note   { font-size: 0.7rem; color: #c47a1a; font-weight: 600; margin-top: 4px; min-height: 1em; }
        .plan-card.dark .price-period { color: rgba(255,255,255,0.4); }
        .plan-card.dark .price-note   { color: #fbbf24; }

        .plan-divider { border: none; border-top: 1px solid #f0ece8; margin: 0 0 1.125rem; }
        .plan-card.dark .plan-divider { border-top-color: rgba(255,255,255,0.1); }

        .features { list-style: none; display: flex; flex-direction: column; gap: 0.55rem; margin-bottom: 1.5rem; flex: 1; }
        .features li {
            display: flex; align-items: flex-start; gap: 0.55rem;
            font-size: 0.8125rem; color: #374151; line-height: 1.4;
        }
        .plan-card.dark .features li { color: rgba(255,255,255,0.75); }
        .check {
            width: 17px; height: 17px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; margin-top: 1px;
        }
        .cross {
            width: 17px; height: 17px; border-radius: 50%;
            background: #f3f4f6; display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; margin-top: 1px;
        }
        .disabled { color: #9ca3af; }
        .plan-card.dark .disabled { color: rgba(255,255,255,0.3); }

        .plan-btn {
            display: block; width: 100%; padding: 0.8125rem;
            border-radius: 0.875rem; border: none; cursor: pointer;
            font-weight: 700; font-size: 0.875rem; text-align: center;
            text-decoration: none; transition: filter 0.15s, transform 0.1s; font-family: inherit;
            margin-top: auto;
        }
        .plan-btn:hover { filter: brightness(1.08); }
        .plan-btn:active { transform: scale(0.98); }
        .btn-free    { background: #f0fdf4; border: 1.5px solid #bbf7d0; color: #15803d; }
        .btn-free:hover { background: #dcfce7; }
        .btn-outline { background: transparent; border: 1.5px solid #d1d5db; color: #374151; }
        .btn-outline:hover { border-color: #c47a1a; color: #8b4d0f; background: #fffbf5; }
        .btn-primary { background: linear-gradient(135deg, #c47a1a, #8b4d0f); color: white; box-shadow: 0 3px 14px rgba(139,77,15,0.35); }
        .btn-white   { background: white; color: #3d2210; box-shadow: 0 2px 10px rgba(0,0,0,0.25); }
        .btn-white:hover { background: #fdf5ee; }

        .notes { max-width: 680px; margin: 0 auto 3rem; padding: 0 1.25rem; text-align: center; }
        .notes p { font-size: 0.875rem; color: #9ca3af; line-height: 1.7; }
        .notes a { color: #c47a1a; text-decoration: none; font-weight: 600; }
        .notes a:hover { text-decoration: underline; }

        .back-bar {
            background: white; border-bottom: 1px solid rgba(0,0,0,0.06);
            padding: 0.875rem 1.5rem; display: flex; align-items: center; gap: 0.75rem;
        }
        .back-bar a {
            display: inline-flex; align-items: center; gap: 0.4rem;
            font-size: 0.875rem; font-weight: 600; color: #6b7280;
            text-decoration: none; transition: color 0.15s;
        }
        .back-bar a:hover { color: #8b4d0f; }
        .back-bar .logo { margin-left: auto; display: flex; align-items: center; gap: 0.5rem; }
        .back-bar .logo span { font-weight: 700; font-size: 0.9rem; color: #3d2210; }
    </style>
</head>
<body>

<!-- Top bar -->
<div class="back-bar">
    <a href="{{ route('login') }}">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Iniciar sesi&oacute;n
    </a>
    <div class="logo">
        <div style="width:30px;height:30px;border-radius:9px;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#6b4628,#3d2210);">
            <svg width="16" height="16" viewBox="0 0 32 32" fill="none">
                <circle cx="10" cy="11" r="7" fill="rgba(255,255,255,0.4)"/>
                <circle cx="22" cy="11" r="7" fill="rgba(255,255,255,0.4)"/>
                <circle cx="16" cy="22" r="7" fill="rgba(255,255,255,0.6)"/>
            </svg>
        </div>
        <span>Huella Social</span>
    </div>
</div>

<!-- Header -->
<div class="page-header">
    <div class="inner">
        <div class="badge-top">
            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
            </svg>
            Planes y Precios
        </div>
        <h1>Elige el plan que<br>se adapta a ti</h1>
        <p>Sin contratos, sin sorpresas. Empieza gratis y escala cuando lo necesites.</p>
        <div class="billing-toggle" id="billingToggle">
            <span class="lbl-mensual">Mensual</span>
            <div class="toggle-pill"></div>
            <span class="lbl-anual">Anual</span>
            <span class="save-badge">Ahorra 20%</span>
        </div>
    </div>
</div>

<!-- Cards -->
<div class="plans-section">

    <!-- GRATIS -->
    <div class="plan-card">
        <div class="plan-icon" style="background:#f0fdf4;">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#16a34a" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
            </svg>
        </div>
        <p class="plan-name" style="color:#16a34a;">Gratis</p>
        <p class="plan-desc">Ideal para estudiantes que quieren explorar las herramientas sin compromiso.</p>
        <div class="price-block">
            <div class="price-free">$0</div>
            <p class="price-period">para siempre &middot; 1 usuario</p>
            <p class="price-note">&nbsp;</p>
        </div>
        <hr class="plan-divider">
        <ul class="features">
            <li>
                <span class="check" style="background:#f0fdf4;"><svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="#16a34a" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                1 usuario
            </li>
            <li>
                <span class="check" style="background:#f0fdf4;"><svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="#16a34a" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                Hasta 3 casos activos
            </li>
            <li>
                <span class="check" style="background:#f0fdf4;"><svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="#16a34a" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                Familograma y Genograma
            </li>
            <li>
                <span class="check" style="background:#f0fdf4;"><svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="#16a34a" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                Guardado automatico
            </li>
            <li class="disabled">
                <span class="cross"><svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="#d1d5db" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></span>
                Ecomapa y Mapa de Redes
            </li>
            <li class="disabled">
                <span class="cross"><svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="#d1d5db" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></span>
                Exportacion SVG / PDF
            </li>
            <li class="disabled">
                <span class="cross"><svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="#d1d5db" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></span>
                Plantillas premium
            </li>
        </ul>
        <a href="{{ route('register', ['plan' => 'gratis']) }}" class="plan-btn btn-free">Crear cuenta gratis</a>
    </div>

    <!-- BASICO -->
    <div class="plan-card">
        <div class="plan-icon" style="background:#eff6ff;">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#3b82f6" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
        </div>
        <p class="plan-name" style="color:#3b82f6;">Basico</p>
        <p class="plan-desc">Para profesionales independientes que requieren todas las herramientas de diagnostico.</p>
        <div class="price-block">
            <div class="price-amount" style="color:#1f2937;">
                <span class="p-monthly">$50.000</span>
                <span class="p-annual">$40.000</span>
                <span class="price-suffix" style="color:#6b7280;"> COP</span>
            </div>
            <p class="price-period">
                <span class="p-monthly">por mes &middot; 1 usuario</span>
                <span class="p-annual">por mes &middot; facturado anualmente</span>
            </p>
            <p class="price-note">
                <span class="p-monthly">Ahorra $120.000 con plan anual</span>
                <span class="p-annual">$480.000/ano &mdash; ahorras $120.000</span>
            </p>
        </div>
        <hr class="plan-divider">
        <ul class="features">
            <li>
                <span class="check" style="background:#eff6ff;"><svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="#3b82f6" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                1 usuario
            </li>
            <li>
                <span class="check" style="background:#eff6ff;"><svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="#3b82f6" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                Hasta 20 casos activos
            </li>
            <li>
                <span class="check" style="background:#eff6ff;"><svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="#3b82f6" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                Familograma, Genograma, Ecomapa, Redes
            </li>
            <li>
                <span class="check" style="background:#eff6ff;"><svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="#3b82f6" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                Exportacion SVG
            </li>
            <li>
                <span class="check" style="background:#eff6ff;"><svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="#3b82f6" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                Plantillas basicas prediseñadas
            </li>
            <li class="disabled">
                <span class="cross"><svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="#d1d5db" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></span>
                Exportacion PDF
            </li>
            <li class="disabled">
                <span class="cross"><svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="#d1d5db" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></span>
                Multiples usuarios
            </li>
        </ul>
        <a href="{{ route('register', ['plan' => 'basico']) }}" class="plan-btn btn-outline">Empezar gratis 30 dias</a>
    </div>

    <!-- PROFESIONAL (destacado) -->
    <div class="plan-card featured">
        <div class="popular-badge">&#11088; Mas popular</div>
        <div class="plan-icon" style="background:#fffbeb;">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#c47a1a" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
        </div>
        <p class="plan-name" style="color:#c47a1a;">Profesional</p>
        <p class="plan-desc">Para equipos y profesionales con alto volumen de casos que necesitan colaboracion.</p>
        <div class="price-block">
            <div class="price-amount" style="color:#8b4d0f;">
                <span class="p-monthly">$150.000</span>
                <span class="p-annual">$120.000</span>
                <span class="price-suffix" style="color:#c47a1a;"> COP</span>
            </div>
            <p class="price-period">
                <span class="p-monthly">por mes &middot; hasta 5 usuarios</span>
                <span class="p-annual">por mes &middot; facturado anualmente</span>
            </p>
            <p class="price-note">
                <span class="p-monthly">Ahorra $360.000 con plan anual</span>
                <span class="p-annual">$1.440.000/ano &mdash; ahorras $360.000</span>
            </p>
        </div>
        <hr class="plan-divider">
        <ul class="features">
            <li>
                <span class="check" style="background:#fffbeb;"><svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="#c47a1a" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                Hasta 5 usuarios
            </li>
            <li>
                <span class="check" style="background:#fffbeb;"><svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="#c47a1a" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                Casos ilimitados
            </li>
            <li>
                <span class="check" style="background:#fffbeb;"><svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="#c47a1a" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                Todos los diagramas (F/G/E/R)
            </li>
            <li>
                <span class="check" style="background:#fffbeb;"><svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="#c47a1a" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                Exportacion SVG y PDF
            </li>
            <li>
                <span class="check" style="background:#fffbeb;"><svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="#c47a1a" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                Plantillas premium incluidas
            </li>
            <li>
                <span class="check" style="background:#fffbeb;"><svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="#c47a1a" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                Estadisticas de casos
            </li>
            <li>
                <span class="check" style="background:#fffbeb;"><svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="#c47a1a" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                Roles: admin y profesional
            </li>
        </ul>
        <a href="{{ route('register', ['plan' => 'profesional']) }}" class="plan-btn btn-primary">Empezar gratis 30 dias</a>
    </div>

    <!-- UNIVERSITARIO / INSTITUCIONAL -->
    <div class="plan-card dark">
        <div class="plan-icon" style="background:rgba(255,255,255,0.12);">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="rgba(255,255,255,0.8)" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
            </svg>
        </div>
        <p class="plan-name" style="color:rgba(255,255,255,0.55);">Licencia Universitaria</p>
        <p class="plan-desc">Para universidades, alcaldias, ONGs e instituciones con equipos completos.</p>
        <div class="price-block">
            <div class="price-amount" style="color:white;">
                <span class="p-monthly">$450.000</span>
                <span class="p-annual">$360.000</span>
                <span class="price-suffix" style="color:rgba(255,255,255,0.5);"> COP</span>
            </div>
            <p class="price-period">
                <span class="p-monthly">por mes &middot; usuarios ilimitados</span>
                <span class="p-annual">por mes &middot; facturado anualmente</span>
            </p>
            <p class="price-note">
                <span class="p-monthly">Ahorra $1.080.000 con plan anual</span>
                <span class="p-annual">$4.320.000/ano &mdash; ahorras $1.080.000</span>
            </p>
        </div>
        <hr class="plan-divider">
        <ul class="features">
            <li>
                <span class="check" style="background:rgba(255,255,255,0.1);"><svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="#fbbf24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                Usuarios ilimitados
            </li>
            <li>
                <span class="check" style="background:rgba(255,255,255,0.1);"><svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="#fbbf24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                Casos ilimitados
            </li>
            <li>
                <span class="check" style="background:rgba(255,255,255,0.1);"><svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="#fbbf24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                Todo lo del plan Profesional
            </li>
            <li>
                <span class="check" style="background:rgba(255,255,255,0.1);"><svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="#fbbf24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                Panel de administracion central
            </li>
            <li>
                <span class="check" style="background:rgba(255,255,255,0.1);"><svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="#fbbf24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                Venta de plantillas premium
            </li>
            <li>
                <span class="check" style="background:rgba(255,255,255,0.1);"><svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="#fbbf24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                Capacitacion al equipo incluida
            </li>
            <li>
                <span class="check" style="background:rgba(255,255,255,0.1);"><svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="#fbbf24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span>
                Soporte prioritario 24/7
            </li>
        </ul>
        <a href="mailto:contacto@huellasocial.co" class="plan-btn btn-white">Contactar para cotizacion</a>
    </div>

</div>

<!-- Notas -->
<div class="notes">
    <p>
        &iquest;Tienes preguntas? Escribenos a
        <a href="mailto:contacto@huellasocial.co">contacto@huellasocial.co</a>
        &nbsp;&middot;&nbsp;
        Todos los planes pagos incluyen 30 dias gratis sin tarjeta de credito.
        &nbsp;&middot;&nbsp;
        Precios en pesos colombianos (COP) &middot; IVA no incluido.
    </p>
</div>

<script>
(function () {
    var toggle = document.getElementById('billingToggle');
    if (!toggle) return;
    var isAnnual = false;
    toggle.addEventListener('click', function () {
        isAnnual = !isAnnual;
        document.body.classList.toggle('is-annual', isAnnual);
    });
})();
</script>
</body>
</html>
