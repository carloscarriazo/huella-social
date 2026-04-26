<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <div class="min-w-0">
                <a href="{{ route('casos.show', $caso) }}" class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1 mb-0.5">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    {{ $caso->nombre }}
                </a>
                <h2 class="font-bold text-xl text-gray-800">Mapa Social</h2>
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
                        class="shrink-0 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2 rounded-lg transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V7l-4-4z"/></svg>
                    Guardar
                </button>
            </div>
        </div>
    </x-slot>

    @push('styles')
    <style>
        .prop-label{display:block;font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#6b7280;margin-bottom:.3rem}
        .prop-input{width:100%;border:1px solid #e5e7eb;border-radius:.5rem;padding:.4rem .65rem;font-size:.875rem;color:#1f2937;outline:none;transition:border-color .15s,box-shadow .15s;background:#fafafa}
        .prop-input:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.16);background:#fff}
        .tb-btn{display:inline-flex;align-items:center;gap:5px;padding:.35rem .75rem;border-radius:.5rem;font-size:.78rem;font-weight:600;border:1.5px solid #e5e7eb;background:#fff;color:#374151;cursor:pointer;transition:all .15s;white-space:nowrap}
        .tb-btn:hover{background:#f9fafb;border-color:#d1d5db}
        .tb-btn.active{border-color:#2563eb;background:#eff6ff;color:#2563eb}
        .tb-sep{width:1px;height:24px;background:#e5e7eb;margin:0 4px;flex-shrink:0}
    </style>
    @endpush

    <div class="py-3 space-y-3">

        <!-- Toolbar -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 px-4 py-2.5 flex flex-wrap items-center gap-2">
            <button class="tb-btn active" data-mode="select" onclick="setMode('select')">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5"/></svg>
                Seleccionar
            </button>
            <button class="tb-btn" data-mode="connect" onclick="setMode('connect')">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                Conectar
            </button>
            <div class="tb-sep"></div>
            <span class="text-xs text-gray-400 font-semibold">Agregar:</span>
            <button class="tb-btn" style="border-color:#d1fae5;color:#065f46" onclick="addNodo('familia','#059669')">
                <span class="w-3 h-3 rounded-full bg-emerald-500"></span> Familia
            </button>
            <button class="tb-btn" style="border-color:#dbeafe;color:#1e40af" onclick="addNodo('amigos','#3b82f6')">
                <span class="w-3 h-3 rounded-full bg-blue-500"></span> Amigos
            </button>
            <button class="tb-btn" style="border-color:#fef3c7;color:#92400e" onclick="addNodo('trabajo','#f59e0b')">
                <span class="w-3 h-3 rounded-full bg-amber-500"></span> Trabajo
            </button>
            <button class="tb-btn" style="border-color:#ede9fe;color:#5b21b6" onclick="addNodo('vecinos','#8b5cf6')">
                <span class="w-3 h-3 rounded-full bg-violet-500"></span> Vecinos
            </button>
            <button class="tb-btn" style="border-color:#fee2e2;color:#991b1b" onclick="addNodo('comunidad','#ef4444')">
                <span class="w-3 h-3 rounded-full bg-red-500"></span> Comunidad
            </button>
            <button class="tb-btn" style="border-color:#e2e8f0;color:#475569" onclick="addNodo('otro','#64748b')">
                <span class="w-3 h-3 rounded-full bg-slate-500"></span> Otro
            </button>
            <div class="tb-sep"></div>
            <button class="tb-btn" id="btnZoomIn">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
            </button>
            <button class="tb-btn" id="btnZoomOut">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"/></svg>
            </button>
            <button class="tb-btn ml-auto" style="color:#dc2626;border-color:#fecaca"
                    onclick="if(confirm('¿Limpiar el mapa?')){nodos=[];vinculos=[];deselect();}">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Limpiar
            </button>
        </div>

        <!-- Canvas + Panel -->
        <div class="flex gap-3" class="h-[calc(100dvh-280px)] min-h-[320px]">
            <div class="flex-1 rounded-xl shadow-sm border border-gray-100 overflow-hidden min-w-0 relative"
                 style="background:radial-gradient(circle at 1px 1px,#d1d5db 1px,transparent 0) 0/24px 24px,#f9fafb;">
                <svg id="svgCanvas" style="width:100%;height:100%;background:transparent;cursor:default;">
                    <g id="guidesG"></g>
                    <g id="linksG"></g>
                    <g id="nodesG"></g>
                </svg>
                <div id="connectHint" class="hidden absolute top-3 left-1/2 -translate-x-1/2 bg-amber-50 border border-amber-300 text-amber-700 text-xs px-4 py-2 rounded-full shadow-sm font-medium pointer-events-none">
                    Selecciona el primer nodo · Esc para cancelar
                </div>
                <div id="connectHint2" class="hidden absolute top-3 left-1/2 -translate-x-1/2 bg-blue-50 border border-blue-300 text-blue-700 text-xs px-4 py-2 rounded-full shadow-sm font-medium pointer-events-none">
                    Ahora selecciona el nodo destino
                </div>
            </div>
            <div id="propPanel" class="hidden w-64 bg-white rounded-xl shadow-sm border border-gray-100 overflow-y-auto flex-shrink-0"
                 style="scrollbar-width:thin;scrollbar-color:#e2e8f0 transparent;"></div>
        </div>

        <!-- Leyenda mejorada -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 px-5 py-4">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Leyenda del Mapa Social</p>
            <div class="flex flex-wrap items-center gap-2">
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg border" style="background:#fffbeb;border-color:#fde68a">
                    <span class="inline-block w-10 h-2 rounded-full" style="background:#fbbf24"></span>
                    <span class="text-xs font-semibold" style="color:#92400e">Íntimo</span>
                </div>
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg border" style="background:#eff6ff;border-color:#bfdbfe">
                    <span class="inline-block w-10 h-2 rounded-full" style="background:#60a5fa"></span>
                    <span class="text-xs font-semibold" style="color:#1e40af">Social</span>
                </div>
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg border" style="background:#ecfdf5;border-color:#a7f3d0">
                    <span class="inline-block w-10 h-2 rounded-full" style="background:#34d399"></span>
                    <span class="text-xs font-semibold" style="color:#065f46">Comunidad</span>
                </div>
                <div class="w-px h-5 bg-gray-200 mx-1"></div>
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg border" style="background:#f8fafc;border-color:#e2e8f0">
                    <svg width="28" height="8"><line x1="0" y1="4" x2="28" y2="4" stroke="#334155" stroke-width="3"/></svg>
                    <span class="text-xs font-semibold text-slate-700">Fuerte</span>
                </div>
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg border" style="background:#f8fafc;border-color:#e2e8f0">
                    <svg width="28" height="8"><line x1="0" y1="4" x2="28" y2="4" stroke="#94a3b8" stroke-width="1.5" stroke-dasharray="7,4"/></svg>
                    <span class="text-xs font-semibold text-slate-500">Débil</span>
                </div>
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg border" style="background:#fff1f2;border-color:#fecdd3">
                    <svg width="28" height="8"><line x1="0" y1="4" x2="28" y2="4" stroke="#ef4444" stroke-width="2"/></svg>
                    <span class="text-xs font-semibold" style="color:#b91c1c">Conflicto</span>
                </div>
                <span class="ml-auto text-xs text-gray-400 hidden sm:inline">Scroll=zoom · Alt+drag=mover · Del=eliminar</span>
            </div>
        </div>
    </div>

@push('scripts')
<script>
const SAVE_URL    = "{{ route('graficos.guardar', [$caso->id, 'mapa_redes']) }}";
const CSRF        = document.querySelector('meta[name="csrf-token"]').content;
const DATOS_INI   = @json($grafico->datos ?? []);
const CASO_NOMBRE = "{{ addslashes($caso->nombre) }}";
const LS_KEY      = 'red_{{ $caso->id }}';

let nodos = [], vinculos = [], nextNodo = 1, nextVinculo = 1;
let currentMode = 'select';
let selected = { type:null, id:null };
let dragging = null, connectFrom = null;
let vb = { x:0, y:0, w:900, h:520 };
let isPanning = false, panStart = null;

const svg    = document.getElementById('svgCanvas');
const guidesG= document.getElementById('guidesG');
const linksG = document.getElementById('linksG');
const nodesG = document.getElementById('nodesG');
const panel  = document.getElementById('propPanel');

const CX = 450, CY = 260; // Centro de los círculos guía (coordenadas SVG)

/* ── Helpers ─── */
const getNodo    = id => nodos.find(n=>n.id===id);
const getVinculo = id => vinculos.find(v=>v.id===id);
const esc = s => String(s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
const svgEl = t => document.createElementNS('http://www.w3.org/2000/svg',t);
const attrs = (el,ob) => { Object.entries(ob).forEach(([k,v])=>el.setAttribute(k,v)); return el; };

function s2v(sx,sy){ const r=svg.getBoundingClientRect(); return {x:vb.x+(sx-r.left)/r.width*vb.w, y:vb.y+(sy-r.top)/r.height*vb.h}; }
function applyVB(){ svg.setAttribute('viewBox',`${vb.x} ${vb.y} ${vb.w} ${vb.h}`); }


let _lsTimer = null;
function saveLocal(){
    clearTimeout(_lsTimer);
    _lsTimer = setTimeout(()=>{
        try{ localStorage.setItem(LS_KEY, JSON.stringify({nodos,vinculos})); }catch(e){}
        const b=document.getElementById('autosaveBadge');
        if(b){ b.classList.remove('hidden'); b.textContent='● Sin guardar en BD'; }
    },800);
}

function loadData(d){
    const local=localStorage.getItem(LS_KEY);
    if(local){ try{ d=JSON.parse(local); }catch(e){} }
    if(d?.nodos){ nodos=d.nodos; vinculos=d.vinculos||[]; }
    else if(d?.nodes){ nodos=d.nodes.map(n=>({...n})); vinculos=(d.links||[]).map(l=>({...l})); }
    if(nodos.length){ nextNodo=(Math.max(0,...nodos.map(n=>n.id))+1)||1; nextVinculo=(Math.max(0,...vinculos.map(v=>v.id))+1)||1; }
    if(local){
        const b=document.getElementById('autosaveBadge');
        if(b){ b.classList.remove('hidden'); b.textContent='● Sin guardar en BD'; }
    }
    render();
}

/* ── Render ─── */
function render(){ renderGuides(); renderLinks(); renderNodes(); saveLocal(); }

function renderGuides(){
    guidesG.innerHTML='';
    const rings=[
        {r:85, color:'#fbbf24', label:'Íntimo'},
        {r:165, color:'#60a5fa', label:'Social'},
        {r:250, color:'#34d399', label:'Comunidad'},
    ];
    rings.forEach(ring=>{
        const c=attrs(svgEl('circle'),{cx:CX,cy:CY,r:ring.r,fill:'none',stroke:ring.color,'stroke-width':1.5,'stroke-dasharray':'6,5','opacity':.6});
        guidesG.appendChild(c);
        const t=attrs(svgEl('text'),{x:CX,y:CY-ring.r-6,'text-anchor':'middle','font-size':10,fill:ring.color,'opacity':.8});
        t.textContent=ring.label; guidesG.appendChild(t);
    });
    // Centro
    const dot=attrs(svgEl('circle'),{cx:CX,cy:CY,r:6,fill:'#94a3b8'});
    guidesG.appendChild(dot);
}

const FUERZA_STYLES={
    fuerte: { w:3, dash:'' },
    normal: { w:2, dash:'' },
    debil:  { w:1, dash:'8,5' },
    conflicto: { w:2, dash:'', color:'#ef4444' },
};

function renderLinks(){
    linksG.innerHTML='';
    vinculos.forEach(vk=>{
        const a=getNodo(vk.from), b=getNodo(vk.to);
        if(!a||!b) return;
        const isSel=selected.type==='link'&&selected.id===vk.id;
        const st=FUERZA_STYLES[vk.fuerza]||FUERZA_STYLES.normal;
        const stroke=isSel?'#0ea5e9':(st.color||'#64748b');

        linksG.appendChild(attrs(svgEl('line'),{x1:a.x,y1:a.y,x2:b.x,y2:b.y,
            stroke,'stroke-width':isSel?st.w+1.5:st.w,'stroke-dasharray':st.dash||''}));
        // Hitbox
        const hit=attrs(svgEl('line'),{x1:a.x,y1:a.y,x2:b.x,y2:b.y,stroke:'transparent','stroke-width':16,cursor:'pointer'});
        hit.addEventListener('click',e=>{e.stopPropagation();selectItem('link',vk.id);});
        linksG.appendChild(hit);
        if(vk.label){
            const t=attrs(svgEl('text'),{x:(a.x+b.x)/2,y:(a.y+b.y)/2-7,'text-anchor':'middle','font-size':11,fill:'#94a3b8'});
            t.textContent=vk.label; linksG.appendChild(t);
        }
    });
}

const CAT_COLORS={familia:'#059669',amigos:'#3b82f6',trabajo:'#f59e0b',vecinos:'#8b5cf6',comunidad:'#ef4444',otro:'#64748b'};

function renderNodes(){
    nodesG.innerHTML='';
    nodos.forEach(nd=>{
        const isSel=selected.type==='node'&&selected.id===nd.id;
        const color=nd.color||CAT_COLORS[nd.categoria]||'#64748b';
        const G=svgEl('g');
        G.style.cursor=currentMode==='connect'?'crosshair':'grab';
        const r=24;
        G.appendChild(attrs(svgEl('circle'),{cx:nd.x,cy:nd.y,r,
            fill:isSel?color+'44':color+'22',stroke:isSel?'#0ea5e9':color,'stroke-width':isSel?3:2}));
        const tn=attrs(svgEl('text'),{x:nd.x,y:nd.y+4,'text-anchor':'middle','font-size':12,fill:'#1e293b','font-weight':'600'});
        tn.textContent=nd.nombre||nd.categoria||''; G.appendChild(tn);
        const ts=attrs(svgEl('text'),{x:nd.x,y:nd.y+r+14,'text-anchor':'middle','font-size':10,fill:'#94a3b8'});
        ts.textContent=nd.categoria||''; G.appendChild(ts);
        G.addEventListener('mousedown',e=>onNodoMD(e,nd.id));
        nodesG.appendChild(G);
    });
}

/* ── Interacción ─── */
function onNodoMD(e,id){
    e.stopPropagation();
    if(currentMode==='connect'){
        if(!connectFrom){ connectFrom=id; document.getElementById('connectHint').classList.add('hidden'); document.getElementById('connectHint2').classList.remove('hidden'); }
        else if(connectFrom!==id){
            vinculos.push({id:nextVinculo++,from:connectFrom,to:id,fuerza:'normal',label:''});
            connectFrom=null; setMode('select'); render();
        }
        return;
    }
    selectItem('node',id);
    const p=s2v(e.clientX,e.clientY), nd=getNodo(id);
    dragging={id,ox:p.x-nd.x,oy:p.y-nd.y};
}

function selectItem(type,id){ selected={type,id}; render(); renderPanel(); }
function deselect(){ selected={type:null,id:null}; render(); renderPanel(); }
function deleteSelected(){
    if(selected.type==='node'){ nodos=nodos.filter(n=>n.id!==selected.id); vinculos=vinculos.filter(v=>v.from!==selected.id&&v.to!==selected.id); }
    else if(selected.type==='link'){ vinculos=vinculos.filter(v=>v.id!==selected.id); }
    deselect();
}
function setMode(m){
    currentMode=m; connectFrom=null;
    svg.style.cursor=m==='connect'?'crosshair':'default';
    document.getElementById('connectHint').classList.toggle('hidden',m!=='connect');
    document.getElementById('connectHint2').classList.add('hidden');
    document.querySelectorAll('[data-mode]').forEach(b=>b.classList.toggle('active',b.dataset.mode===m));
}
function addNodo(cat,color){
    const angle=Math.random()*Math.PI*2;
    const rings={familia:70,amigos:130,trabajo:130,vecinos:200,comunidad:210,otro:180};
    const r=(rings[cat]||130)+(Math.random()-.5)*40;
    nodos.push({id:nextNodo++,categoria:cat,nombre:cat,color,notas:'',x:CX+Math.cos(angle)*r,y:CY+Math.sin(angle)*r});
    render();
}

/* ── Pan & Zoom ─── */
svg.addEventListener('wheel',e=>{
    e.preventDefault();
    const f=e.deltaY>0?1.12:.89, r=svg.getBoundingClientRect();
    const mx=vb.x+(e.clientX-r.left)/r.width*vb.w, my=vb.y+(e.clientY-r.top)/r.height*vb.h;
    vb.w*=f; vb.h*=f;
    vb.x=mx-(e.clientX-r.left)/r.width*vb.w;
    vb.y=my-(e.clientY-r.top)/r.height*vb.h;
    applyVB();
},{passive:false});
svg.addEventListener('mousedown',e=>{
    if(e.button===1||(e.button===0&&e.altKey)){ isPanning=true; const r=svg.getBoundingClientRect(); panStart={sx:e.clientX,sy:e.clientY,vx:vb.x,vy:vb.y,rw:r.width,rh:r.height}; e.preventDefault(); }
});
svg.addEventListener('click',e=>{ if(e.target===svg||e.target.tagName==='svg') deselect(); });
document.addEventListener('mousemove',e=>{
    if(dragging){ const p=s2v(e.clientX,e.clientY),nd=getNodo(dragging.id); if(nd){nd.x=p.x-dragging.ox;nd.y=p.y-dragging.oy;render();} return; }
    if(isPanning&&panStart){ vb.x=panStart.vx-(e.clientX-panStart.sx)/panStart.rw*vb.w; vb.y=panStart.vy-(e.clientY-panStart.sy)/panStart.rh*vb.h; applyVB(); }
});
document.addEventListener('mouseup',()=>{dragging=null;isPanning=false;panStart=null;});
document.addEventListener('keydown',e=>{
    const tag=document.activeElement?.tagName;
    if(tag==='INPUT'||tag==='TEXTAREA'||tag==='SELECT') return;
    if(e.key==='Delete'||e.key==='Backspace') deleteSelected();
    if(e.key==='Escape'){setMode('select');deselect();}
});
document.getElementById('btnZoomIn').onclick=()=>{const cx=vb.x+vb.w/2,cy=vb.y+vb.h/2;vb.w*=.8;vb.h*=.8;vb.x=cx-vb.w/2;vb.y=cy-vb.h/2;applyVB();};
document.getElementById('btnZoomOut').onclick=()=>{const cx=vb.x+vb.w/2,cy=vb.y+vb.h/2;vb.w*=1.25;vb.h*=1.25;vb.x=cx-vb.w/2;vb.y=cy-vb.h/2;applyVB();};

/* ── Panel de propiedades ─── */
function renderPanel(){
    if(!selected.type){panel.classList.add('hidden');return;}
    panel.classList.remove('hidden');
    if(selected.type==='node'){
        const n=getNodo(selected.id); if(!n) return;
        const cats=['familia','amigos','trabajo','vecinos','comunidad','otro'];
        const catOpts=cats.map(c=>`<option value="${c}" ${n.categoria===c?'selected':''}>${c.charAt(0).toUpperCase()+c.slice(1)}</option>`).join('');
        panel.innerHTML=`
        <div class="p-4 space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <span class="text-sm font-bold text-gray-700">Nodo</span>
                <button onclick="deleteSelected()" class="text-xs text-red-500 hover:text-red-700 font-medium px-2 py-1 rounded hover:bg-red-50 transition">Eliminar</button>
            </div>
            <div><label class="prop-label">Nombre</label>
                <input id="pp_n" class="prop-input" type="text" value="${esc(n.nombre)}"></div>
            <div><label class="prop-label">Categoría</label>
                <select id="pp_c" class="prop-input">${catOpts}</select></div>
            <div><label class="prop-label">Color</label>
                <input id="pp_col" class="prop-input" type="color" value="${n.color||'#64748b'}" style="height:36px;padding:2px 4px"></div>
            <div><label class="prop-label">Notas</label>
                <textarea id="pp_o" class="prop-input" rows="3">${esc(n.notas)}</textarea></div>
        </div>`;
        document.getElementById('pp_n').oninput   = e=>{n.nombre=e.target.value;render();};
        document.getElementById('pp_c').onchange  = e=>{n.categoria=e.target.value;n.color=CAT_COLORS[e.target.value]||n.color;document.getElementById('pp_col').value=n.color;render();};
        document.getElementById('pp_col').oninput = e=>{n.color=e.target.value;render();};
        document.getElementById('pp_o').oninput   = e=>{n.notas=e.target.value;};
    } else if(selected.type==='link'){
        const v=getVinculo(selected.id); if(!v) return;
        const fuerzas=[['fuerte','Fuerte (mucho apoyo)'],['normal','Normal'],['debil','Débil / Poca cercanía'],['conflicto','Conflicto / Tensión']];
        const fOpts=fuerzas.map(([val,lbl])=>`<option value="${val}" ${v.fuerza===val?'selected':''}>${lbl}</option>`).join('');
        panel.innerHTML=`
        <div class="p-4 space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <span class="text-sm font-bold text-gray-700">Vínculo</span>
                <button onclick="deleteSelected()" class="text-xs text-red-500 hover:text-red-700 font-medium px-2 py-1 rounded hover:bg-red-50 transition">Eliminar</button>
            </div>
            <div><label class="prop-label">Fuerza de la relación</label>
                <select id="pp_f" class="prop-input">${fOpts}</select></div>
            <div><label class="prop-label">Etiqueta</label>
                <input id="pp_l" class="prop-input" type="text" value="${esc(v.label)}" placeholder="Ej: apoyo emocional…"></div>
        </div>`;
        document.getElementById('pp_f').onchange=e=>{v.fuerza=e.target.value;render();};
        document.getElementById('pp_l').oninput=e=>{v.label=e.target.value;render();};
    }
}

/* ── Guardar ─── */
document.getElementById('btnGuardar').onclick=async()=>{
    const btn=document.getElementById('btnGuardar');
    btn.disabled=true;btn.textContent='Guardando…';
    try{
        const r=await fetch(SAVE_URL,{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},body:JSON.stringify({datos:{nodos,vinculos}})});
        const j=await r.json();
        btn.textContent=j.success?'✓ Guardado':'✗ Error';
        if(j.success){
            btn.classList.replace('bg-blue-600','bg-green-600');
            localStorage.removeItem(LS_KEY);
            const b=document.getElementById('autosaveBadge');
            if(b){ b.textContent='✓ Guardado en BD'; b.style.cssText='background:#d1fae5;color:#065f46;border:1px solid #6ee7b7'; }
        }
    }catch{btn.textContent='✗ Error de red';}
    setTimeout(()=>{btn.disabled=false;btn.textContent='Guardar';btn.classList.replace('bg-green-600','bg-blue-600');},2500);
};

function exportSVG(){
    const el=document.getElementById('svgCanvas');
    const clone=el.cloneNode(true);
    clone.setAttribute('xmlns','http://www.w3.org/2000/svg');
    clone.removeAttribute('style');
    clone.setAttribute('width','900'); clone.setAttribute('height','520');
    const s=new XMLSerializer().serializeToString(clone);
    const blob=new Blob([s],{type:'image/svg+xml;charset=utf-8'});
    const url=URL.createObjectURL(blob);
    const a=document.createElement('a');
    a.href=url; a.download='mapa_redes_{{ Str::slug($caso->nombre) }}.svg';
    document.body.appendChild(a); a.click(); document.body.removeChild(a);
    URL.revokeObjectURL(url);
}

applyVB();
loadData(DATOS_INI);
renderPanel();
</script>
@endpush
</x-app-layout>
