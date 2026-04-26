<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <div class="min-w-0">
                <a href="{{ route('casos.show', $caso) }}" class="text-sm text-teal-600 hover:text-teal-800 flex items-center gap-1 mb-0.5">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    {{ $caso->nombre }}
                </a>
                <h2 class="font-bold text-xl text-gray-800">Genograma</h2>
            </div>
            <div class="flex items-center gap-2">
                <span id="autosaveBadge" class="hidden text-xs font-medium px-2.5 py-1 rounded-full"
                      style="background:#fef3c7;color:#92400e;border:1px solid #fde68a">● Sin guardar en BD</span>
                <button onclick="exportSVG()"
                        class="shrink-0 inline-flex items-center gap-1.5 text-sm font-semibold px-4 py-2 rounded-lg transition shadow-sm"
                        style="background:#f3e5d0;color:#6b4423;border:1.5px solid #d6b896;">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    SVG
                </button>
                <button id="btnGuardar"
                        class="shrink-0 inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-5 py-2 rounded-lg transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V7l-4-4z"/><path stroke-linecap="round" stroke-linejoin="round" d="M17 3v4H9V3"/></svg>
                    Guardar
                </button>
            </div>
        </div>
    </x-slot>

    @push('styles')
    <style>
        .prop-label { display:block; font-size:0.7rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:#6b7280; margin-bottom:0.3rem; }
        .prop-input { width:100%; border:1px solid #e5e7eb; border-radius:0.5rem; padding:0.4rem 0.65rem; font-size:0.875rem; color:#1f2937; outline:none; transition:border-color .15s, box-shadow .15s; background:#fafafa; }
        .prop-input:focus { border-color:#0d9488; box-shadow:0 0 0 3px rgba(13,148,136,.18); background:#fff; }
        .tb-btn { display:inline-flex; align-items:center; gap:5px; padding:0.35rem 0.75rem; border-radius:0.5rem; font-size:0.78rem; font-weight:600; border:1.5px solid #e5e7eb; background:#fff; color:#374151; cursor:pointer; transition:all .15s; white-space:nowrap; }
        .tb-btn:hover { background:#f9fafb; border-color:#d1d5db; }
        .tb-btn.active { border-color:#0d9488; background:#f0fdfa; color:#0d9488; }
        .tb-sep { width:1px; height:24px; background:#e5e7eb; margin:0 4px; flex-shrink:0; }
    </style>
    @endpush

    <div class="py-3 space-y-3">

        <!-- Toolbar -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 px-4 py-2.5 flex flex-wrap items-center gap-2">
            <button id="btnSeleccionar" class="tb-btn active" data-mode="select" onclick="setMode('select')">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5"/></svg>
                Seleccionar
            </button>
            <button id="btnConectar" class="tb-btn" data-mode="connect" onclick="setMode('connect')">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                Conectar
            </button>
            <div class="tb-sep"></div>
            <span class="text-xs text-gray-400 font-semibold">Agregar:</span>
            <button class="tb-btn" onclick="addNode('M','Hombre')">
                <span class="inline-block w-4 h-4 border-2 border-blue-500 rounded-sm bg-blue-50"></span> Hombre
            </button>
            <button class="tb-btn" onclick="addNode('F','Mujer')">
                <span class="inline-block w-4 h-4 border-2 border-pink-500 rounded-full bg-pink-50"></span> Mujer
            </button>
            <button class="tb-btn" onclick="addNode('X','Otro')">
                <span class="inline-block w-4 h-4 border-2 border-indigo-400 bg-indigo-50" style="transform:rotate(45deg)"></span> Otro
            </button>
            <div class="tb-sep"></div>
            <button class="tb-btn" id="btnZoomIn" title="Acercar (+)">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
            </button>
            <button class="tb-btn" id="btnZoomOut" title="Alejar (-)">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"/></svg>
            </button>
            <button class="tb-btn" id="btnFit" title="Ajustar vista">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
            </button>
            <div class="tb-sep"></div>
            <button class="tb-btn ml-auto" style="color:#dc2626;border-color:#fecaca"
                    onclick="if(confirm('¿Limpiar todo el genograma?')){nodes=[];links=[];deselect();}">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Limpiar
            </button>
        </div>

        <!-- Canvas + Panel -->
        <div class="flex gap-3" class="h-[calc(100dvh-280px)] min-h-[320px]">

            <!-- Canvas -->
            <div class="flex-1 rounded-xl shadow-sm border border-gray-100 overflow-hidden min-w-0 relative"
                 style="background: radial-gradient(circle at 1px 1px,#d1d5db 1px,transparent 0) 0/24px 24px, #f9fafb;">
                <svg id="svgCanvas" style="width:100%;height:100%;background:transparent;cursor:default;">
                    <defs>
                        <marker id="arr" markerWidth="8" markerHeight="6" refX="8" refY="3" orient="auto">
                            <polygon points="0 0,8 3,0 6" fill="#475569"/>
                        </marker>
                    </defs>
                    <g id="linksG"></g>
                    <g id="nodesG"></g>
                </svg>
                <!-- Indicador modo conectar -->
                <div id="connectHint" class="hidden absolute top-3 left-1/2 -translate-x-1/2 bg-amber-50 border border-amber-300 text-amber-700 text-xs px-4 py-2 rounded-full shadow-sm font-medium pointer-events-none">
                    Haz clic en el primer nodo para iniciar la conexión • Esc para cancelar
                </div>
                <div id="connectHint2" class="hidden absolute top-3 left-1/2 -translate-x-1/2 bg-teal-50 border border-teal-300 text-teal-700 text-xs px-4 py-2 rounded-full shadow-sm font-medium pointer-events-none">
                    Nodo origen seleccionado — ahora haz clic en el nodo destino
                </div>
            </div>

            <!-- Panel de propiedades -->
            <div id="propPanel" class="hidden w-64 bg-white rounded-xl shadow-sm border border-gray-100 overflow-y-auto flex-shrink-0"
                 style="scrollbar-width:thin;scrollbar-color:#e2e8f0 transparent;">
                <!-- Se rellena por JS -->
            </div>
        </div>

        <!-- Leyenda mejorada -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 px-5 py-4">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Leyenda del Genograma</p>
            <div class="flex flex-wrap items-center gap-2">
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg border" style="background:#eff6ff;border-color:#bfdbfe">
                    <svg width="16" height="16" viewBox="0 0 16 16"><rect x="1" y="1" width="14" height="14" rx="2" fill="#dbeafe" stroke="#3b82f6" stroke-width="2"/></svg>
                    <span class="text-xs font-semibold" style="color:#1d4ed8">Hombre</span>
                </div>
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg border" style="background:#fdf2f8;border-color:#fbcfe8">
                    <svg width="16" height="16" viewBox="0 0 16 16"><circle cx="8" cy="8" r="7" fill="#fce7f3" stroke="#ec4899" stroke-width="2"/></svg>
                    <span class="text-xs font-semibold" style="color:#9d174d">Mujer</span>
                </div>
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg border" style="background:#f5f3ff;border-color:#ddd6fe">
                    <svg width="16" height="18" viewBox="0 0 16 18"><polygon points="8,1 15,9 8,17 1,9" fill="#eef2ff" stroke="#6366f1" stroke-width="2"/></svg>
                    <span class="text-xs font-semibold" style="color:#4338ca">Otro</span>
                </div>
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg border" style="background:#f8fafc;border-color:#e2e8f0">
                    <svg width="16" height="16" viewBox="0 0 16 16"><rect x="1" y="1" width="14" height="14" rx="2" fill="#e2e8f0" stroke="#64748b" stroke-width="1.5"/><line x1="3" y1="3" x2="13" y2="13" stroke="#475569" stroke-width="2"/><line x1="13" y1="3" x2="3" y2="13" stroke="#475569" stroke-width="2"/></svg>
                    <span class="text-xs font-semibold text-gray-600">Fallecido/a</span>
                </div>
                <div class="w-px h-5 bg-gray-200 mx-1"></div>
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg border" style="background:#f8fafc;border-color:#e2e8f0">
                    <svg width="28" height="8"><line x1="0" y1="4" x2="28" y2="4" stroke="#1e293b" stroke-width="3"/></svg>
                    <span class="text-xs font-semibold text-slate-700">Matrimonio</span>
                </div>
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg border" style="background:#f8fafc;border-color:#e2e8f0">
                    <svg width="28" height="8"><line x1="0" y1="4" x2="28" y2="4" stroke="#64748b" stroke-width="2" stroke-dasharray="7,4"/></svg>
                    <span class="text-xs font-semibold text-slate-600">Separados</span>
                </div>
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg border" style="background:#fff1f2;border-color:#fecdd3">
                    <svg width="28" height="8"><line x1="0" y1="4" x2="28" y2="4" stroke="#dc2626" stroke-width="2"/></svg>
                    <span class="text-xs font-semibold" style="color:#b91c1c">Conflicto</span>
                </div>
                <span class="ml-auto text-xs text-gray-400 hidden sm:inline">Scroll=zoom · Alt+drag=mover · Del=eliminar</span>
            </div>
        </div>
    </div>

@push('scripts')
<script>
const SAVE_URL    = "{{ route('graficos.guardar', [$caso->id, 'genograma']) }}";
const CSRF        = document.querySelector('meta[name="csrf-token"]').content;
const DATOS_INI   = @json($grafico->datos ?? []);
const CASO_NOMBRE = "{{ addslashes($caso->nombre) }}";
const LS_KEY      = 'gen_{{ $caso->id }}';

/* ── Estado ─────────────────────────────────────────── */
let nodes = [], links = [], nextNode = 1, nextLink = 1;
let currentMode = 'select';
let selected    = { type: null, id: null };
let dragging    = null;   // { id, ox, oy }
let connectFrom = null;
let vb = { x: 0, y: 0, w: 900, h: 520 };
let isPanning = false, panStart = null;

const svg    = document.getElementById('svgCanvas');
const linksG = document.getElementById('linksG');
const nodesG = document.getElementById('nodesG');
const panel  = document.getElementById('propPanel');

/* ── Coords ─────────────────────────────────────────── */
function s2v(sx, sy) {
    const r = svg.getBoundingClientRect();
    return { x: vb.x + (sx - r.left) / r.width * vb.w,
             y: vb.y + (sy - r.top)  / r.height * vb.h };
}
function applyVB() { svg.setAttribute('viewBox', `${vb.x} ${vb.y} ${vb.w} ${vb.h}`); }

/* ── Helpers ─────────────────────────────────────────── */
const getNode = id => nodes.find(n => n.id === id);
const getLink = id => links.find(l => l.id === id);
const esc = s  => String(s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
const svgEl = tag => document.createElementNS('http://www.w3.org/2000/svg', tag);
function attrs(el, ob) { Object.entries(ob).forEach(([k,v]) => el.setAttribute(k,v)); return el; }

/* ── Load ────────────────────────────────────────────── */

let _lsTimer = null;
function saveLocal() {
    clearTimeout(_lsTimer);
    _lsTimer = setTimeout(() => {
        try { localStorage.setItem(LS_KEY, JSON.stringify({nodes, links})); } catch(e){}
        const b = document.getElementById('autosaveBadge');
        if (b) { b.classList.remove('hidden'); b.textContent = '● Sin guardar en BD'; }
    }, 800);
}

function loadData(d) {
    const local = localStorage.getItem(LS_KEY);
    if (local) { try { d = JSON.parse(local); } catch(e){} }
    if (!d?.nodes) return;
    nodes = d.nodes; links = d.links || [];
    nextNode = (Math.max(0, ...nodes.map(n=>n.id)) + 1) || 1;
    nextLink = (Math.max(0, ...links.map(l=>l.id)) + 1) || 1;
    if (local) {
        const b = document.getElementById('autosaveBadge');
        if (b) { b.classList.remove('hidden'); b.textContent = '● Sin guardar en BD'; }
    }
    render();
}

/* ── Render SVG ──────────────────────────────────────── */
function render() { renderLinks(); renderNodes(); saveLocal(); }

const LINK_STYLES = {
    matrimonio: { stroke:'#1e293b', w:3, dash:'' },
    union:      { stroke:'#475569', w:2, dash:'' },
    padre_hijo: { stroke:'#334155', w:1.5, dash:'', marker:true },
    separados:  { stroke:'#64748b', w:2, dash:'8,5' },
    divorciados:{ stroke:'#ef4444', w:2, dash:'8,5' },
    conflicto:  { stroke:'#dc2626', w:2, dash:'' },
    distante:   { stroke:'#94a3b8', w:1, dash:'14,8' },
};

function renderLinks() {
    linksG.innerHTML = '';
    links.forEach(lk => {
        const a = getNode(lk.from), b = getNode(lk.to);
        if (!a||!b) return;
        const isSel = selected.type==='link' && selected.id===lk.id;
        const st    = LINK_STYLES[lk.tipo] || LINK_STYLES.union;
        const stroke = isSel ? '#0ea5e9' : st.stroke;

        const line = attrs(svgEl('line'), {
            x1:a.x, y1:a.y, x2:b.x, y2:b.y,
            stroke, 'stroke-width': isSel ? st.w+1.5 : st.w,
            'stroke-dasharray': st.dash || '',
            ...(st.marker ? { 'marker-end':'url(#arr)' } : {})
        });
        linksG.appendChild(line);

        // Hitbox
        const hit = attrs(svgEl('line'), { x1:a.x, y1:a.y, x2:b.x, y2:b.y,
            stroke:'transparent', 'stroke-width':16, cursor:'pointer' });
        hit.addEventListener('click', e => { e.stopPropagation(); selectItem('link', lk.id); });
        linksG.appendChild(hit);

        // Barra divorcio
        if (lk.tipo === 'divorciados') {
            const mx=(a.x+b.x)/2, my=(a.y+b.y)/2;
            linksG.appendChild(attrs(svgEl('line'),{ x1:mx-7,y1:my-7,x2:mx+7,y2:my+7, stroke:'#ef4444','stroke-width':2.5 }));
        }
        // Etiqueta
        if (lk.label) {
            const t = attrs(svgEl('text'),{ x:(a.x+b.x)/2, y:(a.y+b.y)/2-7,'text-anchor':'middle','font-size':11,fill:'#94a3b8' });
            t.textContent = lk.label;
            linksG.appendChild(t);
        }
    });
}

function renderNodes() {
    nodesG.innerHTML = '';
    nodes.forEach(nd => {
        const isSel = selected.type==='node' && selected.id===nd.id;
        const G = svgEl('g');
        G.style.cursor = currentMode==='connect' ? 'crosshair' : 'grab';

        if (nd.genero==='M') {
            G.appendChild(attrs(svgEl('rect'),{
                x:nd.x-24, y:nd.y-24, width:48, height:48, rx:3,
                fill: isSel?'#bae6fd':'#dbeafe',
                stroke: isSel?'#0ea5e9':'#3b82f6', 'stroke-width': isSel?3:2
            }));
        } else if (nd.genero==='F') {
            G.appendChild(attrs(svgEl('circle'),{
                cx:nd.x, cy:nd.y, r:24,
                fill: isSel?'#fbcfe8':'#fce7f3',
                stroke: isSel?'#0ea5e9':'#ec4899', 'stroke-width': isSel?3:2
            }));
        } else {
            const d = svgEl('polygon');
            d.setAttribute('points',`${nd.x},${nd.y-26} ${nd.x+24},${nd.y} ${nd.x},${nd.y+26} ${nd.x-24},${nd.y}`);
            attrs(d,{ fill:isSel?'#e0e7ff':'#eef2ff', stroke:isSel?'#0ea5e9':'#6366f1','stroke-width':isSel?3:2 });
            G.appendChild(d);
        }

        // Fallecido (X)
        if (nd.fallecido) {
            G.appendChild(attrs(svgEl('line'),{ x1:nd.x-17,y1:nd.y-17,x2:nd.x+17,y2:nd.y+17, stroke:'#475569','stroke-width':2.5 }));
            G.appendChild(attrs(svgEl('line'),{ x1:nd.x+17,y1:nd.y-17,x2:nd.x-17,y2:nd.y+17, stroke:'#475569','stroke-width':2.5 }));
        }

        // Nombre
        const tn = attrs(svgEl('text'),{ x:nd.x, y:nd.y+40,'text-anchor':'middle','font-size':12,fill:'#1e293b','font-weight':'600' });
        tn.textContent = nd.nombre || '';
        G.appendChild(tn);

        // Sub (edad·rol)
        const sub = [nd.edad?nd.edad+' años':'', nd.rol].filter(Boolean).join(' · ');
        if (sub) {
            const ts = attrs(svgEl('text'),{ x:nd.x, y:nd.y+54,'text-anchor':'middle','font-size':10,fill:'#64748b' });
            ts.textContent = sub;
            G.appendChild(ts);
        }

        G.addEventListener('mousedown', e => onNodeMD(e, nd.id));
        nodesG.appendChild(G);
    });
}

/* ── Interacción nodos ───────────────────────────────── */
function onNodeMD(e, id) {
    e.stopPropagation();
    if (currentMode === 'connect') {
        if (!connectFrom) {
            connectFrom = id;
            document.getElementById('connectHint').classList.add('hidden');
            document.getElementById('connectHint2').classList.remove('hidden');
        } else if (connectFrom !== id) {
            links.push({ id:nextLink++, from:connectFrom, to:id, tipo:'union', label:'' });
            connectFrom = null;
            setMode('select');
            render();
        }
        return;
    }
    selectItem('node', id);
    const p = s2v(e.clientX, e.clientY);
    const nd = getNode(id);
    dragging = { id, ox: p.x - nd.x, oy: p.y - nd.y };
}

/* ── Selección ───────────────────────────────────────── */
function selectItem(type, id) {
    selected = { type, id };
    render();
    renderPanel();
}
function deselect() {
    selected = { type:null, id:null };
    render();
    renderPanel();
}
function deleteSelected() {
    if (selected.type==='node') {
        nodes = nodes.filter(n => n.id !== selected.id);
        links = links.filter(l => l.from!==selected.id && l.to!==selected.id);
    } else if (selected.type==='link') {
        links = links.filter(l => l.id !== selected.id);
    }
    deselect();
}

/* ── Modos ───────────────────────────────────────────── */
function setMode(m) {
    currentMode = m; connectFrom = null;
    svg.style.cursor = m==='connect' ? 'crosshair' : 'default';
    document.getElementById('connectHint').classList.toggle('hidden', m!=='connect');
    document.getElementById('connectHint2').classList.add('hidden');
    document.querySelectorAll('[data-mode]').forEach(b => b.classList.toggle('active', b.dataset.mode===m));
}

function addNode(genero, nombre) {
    const cx = vb.x + vb.w/2 + (Math.random()-.5)*180;
    const cy = vb.y + vb.h/2 + (Math.random()-.5)*120;
    nodes.push({ id:nextNode++, genero, nombre, rol:'', edad:'', fallecido:false, notas:'', x:cx, y:cy });
    render();
}

/* ── Pan & Zoom ──────────────────────────────────────── */
svg.addEventListener('wheel', e => {
    e.preventDefault();
    const f = e.deltaY>0 ? 1.12 : 0.89;
    const r = svg.getBoundingClientRect();
    const mx = vb.x + (e.clientX-r.left)/r.width*vb.w;
    const my = vb.y + (e.clientY-r.top)/r.height*vb.h;
    vb.w *= f; vb.h *= f;
    vb.x = mx - (e.clientX-r.left)/r.width*vb.w;
    vb.y = my - (e.clientY-r.top)/r.height*vb.h;
    applyVB();
}, { passive:false });

svg.addEventListener('mousedown', e => {
    if (e.button===1 || (e.button===0 && e.altKey)) {
        isPanning=true;
        const r=svg.getBoundingClientRect();
        panStart={ sx:e.clientX, sy:e.clientY, vx:vb.x, vy:vb.y, rw:r.width, rh:r.height };
        e.preventDefault();
    }
});
svg.addEventListener('click', e => {
    if (e.target===svg || e.target.tagName==='svg') deselect();
});

document.addEventListener('mousemove', e => {
    if (dragging) {
        const p = s2v(e.clientX, e.clientY);
        const nd = getNode(dragging.id);
        if (nd) { nd.x = p.x-dragging.ox; nd.y = p.y-dragging.oy; render(); }
        return;
    }
    if (isPanning && panStart) {
        vb.x = panStart.vx - (e.clientX-panStart.sx)/panStart.rw*vb.w;
        vb.y = panStart.vy - (e.clientY-panStart.sy)/panStart.rh*vb.h;
        applyVB();
    }
});
document.addEventListener('mouseup', () => { dragging=null; isPanning=false; panStart=null; });

document.addEventListener('keydown', e => {
    const tag = document.activeElement?.tagName;
    if (tag==='INPUT'||tag==='TEXTAREA'||tag==='SELECT') return;
    if (e.key==='Delete'||e.key==='Backspace') deleteSelected();
    if (e.key==='Escape') { setMode('select'); deselect(); }
});

document.getElementById('btnZoomIn').onclick  = () => { zoom(.8); };
document.getElementById('btnZoomOut').onclick = () => { zoom(1.25); };
document.getElementById('btnFit').onclick     = fitView;

function zoom(f) {
    const cx=vb.x+vb.w/2, cy=vb.y+vb.h/2;
    vb.w*=f; vb.h*=f; vb.x=cx-vb.w/2; vb.y=cy-vb.h/2; applyVB();
}
function fitView() {
    if (!nodes.length) { vb={x:0,y:0,w:900,h:520}; applyVB(); return; }
    const xs=nodes.map(n=>n.x), ys=nodes.map(n=>n.y), p=80;
    vb={x:Math.min(...xs)-p, y:Math.min(...ys)-p, w:Math.max(...xs)-Math.min(...xs)+p*2, h:Math.max(...ys)-Math.min(...ys)+p*2};
    applyVB();
}

/* ── Panel de propiedades ────────────────────────────── */
function renderPanel() {
    if (!selected.type) { panel.classList.add('hidden'); return; }
    panel.classList.remove('hidden');

    if (selected.type==='node') {
        const n = getNode(selected.id);
        if (!n) return;
        panel.innerHTML = `
        <div class="p-4 space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <span class="text-sm font-bold text-gray-700">Nodo</span>
                <button onclick="deleteSelected()" class="text-xs text-red-500 hover:text-red-700 font-medium px-2 py-1 rounded hover:bg-red-50 transition">Eliminar</button>
            </div>
            <div><label class="prop-label">Nombre</label>
                <input id="pp_n" class="prop-input" type="text" value="${esc(n.nombre)}"></div>
            <div><label class="prop-label">Género</label>
                <select id="pp_g" class="prop-input">
                    <option value="M" ${n.genero==='M'?'selected':''}>♂ Hombre</option>
                    <option value="F" ${n.genero==='F'?'selected':''}>♀ Mujer</option>
                    <option value="X" ${n.genero==='X'?'selected':''}>⬡ Otro/Desconocido</option>
                </select></div>
            <div><label class="prop-label">Rol en la familia</label>
                <input id="pp_r" class="prop-input" type="text" value="${esc(n.rol)}" placeholder="Padre, Madre, Hijo/a…"></div>
            <div><label class="prop-label">Edad</label>
                <input id="pp_e" class="prop-input" type="number" min="0" max="130" value="${esc(n.edad)}" placeholder="años"></div>
            <div class="flex items-center gap-2 py-0.5">
                <input id="pp_f" type="checkbox" ${n.fallecido?'checked':''} class="w-4 h-4 rounded border-gray-300 text-teal-600 cursor-pointer">
                <label for="pp_f" class="text-sm text-gray-600 cursor-pointer">Fallecido/a</label>
            </div>
            <div><label class="prop-label">Notas / Observaciones</label>
                <textarea id="pp_o" class="prop-input" rows="3" placeholder="Información adicional…">${esc(n.notas)}</textarea></div>
        </div>`;
        document.getElementById('pp_n').oninput = e => { n.nombre=e.target.value; render(); };
        document.getElementById('pp_g').onchange= e => { n.genero=e.target.value; render(); };
        document.getElementById('pp_r').oninput = e => { n.rol=e.target.value; render(); };
        document.getElementById('pp_e').oninput = e => { n.edad=e.target.value; render(); };
        document.getElementById('pp_f').onchange= e => { n.fallecido=e.target.checked; render(); };
        document.getElementById('pp_o').oninput = e => { n.notas=e.target.value; };

    } else if (selected.type==='link') {
        const l = getLink(selected.id);
        if (!l) return;
        const ops = [
            ['matrimonio','💍 Matrimonio'],['union','🤝 Unión libre'],
            ['separados','⌇ Separados'],['divorciados','✂ Divorciados'],
            ['padre_hijo','↓ Padre / Hijo'],['conflicto','⚡ Conflicto'],['distante','- - Relación distante'],
        ].map(([v,t])=>`<option value="${v}" ${l.tipo===v?'selected':''}>${t}</option>`).join('');
        panel.innerHTML = `
        <div class="p-4 space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <span class="text-sm font-bold text-gray-700">Vínculo</span>
                <button onclick="deleteSelected()" class="text-xs text-red-500 hover:text-red-700 font-medium px-2 py-1 rounded hover:bg-red-50 transition">Eliminar</button>
            </div>
            <div><label class="prop-label">Tipo de relación</label>
                <select id="pp_t" class="prop-input">${ops}</select></div>
            <div><label class="prop-label">Etiqueta</label>
                <input id="pp_l" class="prop-input" type="text" value="${esc(l.label)}" placeholder="Ej: 15 años, 2018…"></div>
        </div>`;
        document.getElementById('pp_t').onchange = e => { l.tipo=e.target.value; render(); };
        document.getElementById('pp_l').oninput  = e => { l.label=e.target.value; render(); };
    }
}

/* ── Guardar ─────────────────────────────────────────── */
document.getElementById('btnGuardar').onclick = async () => {
    const btn = document.getElementById('btnGuardar');
    btn.disabled=true; btn.textContent='Guardando…';
    try {
        const r = await fetch(SAVE_URL,{method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
            body:JSON.stringify({datos:{nodes,links}})});
        const j = await r.json();
        btn.innerHTML = j.success ? '✓ Guardado' : '✗ Error';
        if (j.success) {
            btn.classList.replace('bg-teal-600','bg-green-600');
            localStorage.removeItem(LS_KEY);
            const b = document.getElementById('autosaveBadge');
            if (b) { b.textContent = '✓ Guardado en BD'; b.style.cssText='background:#d1fae5;color:#065f46;border:1px solid #6ee7b7'; }
        }
    } catch { btn.textContent='✗ Error de red'; }
    setTimeout(()=>{ btn.disabled=false; btn.innerHTML='<svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V7l-4-4z"/></svg>Guardar'; btn.classList.replace('bg-green-600','bg-teal-600'); },2500);
};

/* ── Exportar SVG ───────────────────────────────── */
function exportSVG() {
    const el = document.getElementById('svgCanvas');
    const clone = el.cloneNode(true);
    clone.setAttribute('xmlns','http://www.w3.org/2000/svg');
    clone.removeAttribute('style');
    clone.setAttribute('width','900'); clone.setAttribute('height','520');
    const s = new XMLSerializer().serializeToString(clone);
    const blob = new Blob([s], {type:'image/svg+xml;charset=utf-8'});
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url; a.download = 'genograma_{{ Str::slug($caso->nombre) }}.svg';
    document.body.appendChild(a); a.click(); document.body.removeChild(a);
    URL.revokeObjectURL(url);
}

/* ── Init ────────────────────────────────────────────── */
applyVB();
loadData(DATOS_INI);
renderPanel();
</script>
@endpush
</x-app-layout>
