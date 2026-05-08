{{-- Global Toast Notification --}}
{{-- Usage: session('success'), session('error'), session('warning'), session('info') --}}

<div id="toastContainer" class="fixed top-6 right-6 z-[9999] flex flex-col gap-3 pointer-events-none" style="min-width:320px;max-width:400px"></div>

@php
    $toasts = [];
    if (session('success')) $toasts[] = ['type' => 'success', 'msg' => session('success')];
    if (session('error'))   $toasts[] = ['type' => 'error',   'msg' => session('error')];
    if (session('warning')) $toasts[] = ['type' => 'warning', 'msg' => session('warning')];
    if (session('info'))    $toasts[] = ['type' => 'info',    'msg' => session('info')];
    if (session('cart_success')) $toasts[] = ['type' => 'success', 'msg' => session('cart_success')];
    if (session('cart_error'))   $toasts[] = ['type' => 'error',   'msg' => session('cart_error')];
@endphp

@if(count($toasts))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toasts = @json($toasts);
        toasts.forEach((t, i) => setTimeout(() => showToast(t.type, t.msg), i * 150));
    });
</script>
@endif

<script>
const _toastIcons = {
    success: 'check_circle',
    error:   'cancel',
    warning: 'warning',
    info:    'info',
};
const _toastColors = {
    success: { bg: '#f0fdf4', border: '#86efac', icon: '#16a34a', text: '#15803d' },
    error:   { bg: '#fef2f2', border: '#fca5a5', icon: '#dc2626', text: '#b91c1c' },
    warning: { bg: '#fffbeb', border: '#fcd34d', icon: '#d97706', text: '#b45309' },
    info:    { bg: '#eff6ff', border: '#93c5fd', icon: '#2563eb', text: '#1d4ed8' },
};

function showToast(type, message, duration = 4000) {
    const container = document.getElementById('toastContainer');
    const c = _toastColors[type] || _toastColors.info;
    const icon = _toastIcons[type] || 'info';

    const el = document.createElement('div');
    el.className = 'pointer-events-auto flex items-start gap-3 px-5 py-4 rounded-2xl shadow-xl border translate-x-full opacity-0 transition-all duration-300';
    el.style.cssText = `background:${c.bg};border-color:${c.border};`;
    el.innerHTML = `
        <span class="material-symbols-outlined text-xl shrink-0 mt-0.5" style="color:${c.icon};font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24">${icon}</span>
        <p class="text-sm font-semibold flex-1 leading-snug" style="color:${c.text}">${message}</p>
        <button onclick="dismissToast(this.parentElement)" class="shrink-0 opacity-50 hover:opacity-100 transition-opacity" style="color:${c.text}">
            <span class="material-symbols-outlined text-base">close</span>
        </button>`;

    container.appendChild(el);
    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            el.classList.remove('translate-x-full', 'opacity-0');
        });
    });

    const timer = setTimeout(() => dismissToast(el), duration);
    el._timer = timer;
}

function dismissToast(el) {
    if (!el || !el.parentElement) return;
    clearTimeout(el._timer);
    el.classList.add('translate-x-full', 'opacity-0');
    setTimeout(() => el.remove(), 300);
}

// Pengganti confirm() bawaan browser
function naomiConfirm(message, onConfirm, options = {}) {
    const existing = document.getElementById('naomiConfirmModal');
    if (existing) existing.remove();

    const confirmText = options.confirmText || 'Ya, Lanjutkan';
    const cancelText  = options.cancelText  || 'Batal';
    const danger      = options.danger !== false;

    const modal = document.createElement('div');
    modal.id = 'naomiConfirmModal';
    modal.className = 'fixed inset-0 z-[9998] flex items-center justify-center p-4';
    modal.innerHTML = `
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" id="naomiConfirmBackdrop"></div>
        <div class="relative bg-white rounded-3xl shadow-2xl p-8 max-w-sm w-full border border-slate-100 scale-95 opacity-0 transition-all duration-200" id="naomiConfirmBox">
            <div class="flex flex-col items-center text-center gap-4">
                <div class="size-14 rounded-2xl flex items-center justify-center ${danger ? 'bg-red-50' : 'bg-primary/10'}">
                    <span class="material-symbols-outlined text-3xl ${danger ? 'text-red-500' : 'text-primary'}" style="font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24">${danger ? 'warning' : 'help'}</span>
                </div>
                <p class="text-sm font-semibold text-slate-700 leading-relaxed">${message}</p>
                <div class="flex gap-3 w-full pt-2">
                    <button id="naomiConfirmCancel" class="flex-1 py-3 border-2 border-slate-100 rounded-2xl text-xs font-black uppercase tracking-widest text-slate-400 hover:bg-slate-50 transition-all">
                        ${cancelText}
                    </button>
                    <button id="naomiConfirmOk" class="flex-1 py-3 rounded-2xl text-xs font-black uppercase tracking-widest text-white shadow-lg transition-all ${danger ? 'bg-red-500 hover:bg-red-600 shadow-red-200' : 'bg-primary hover:bg-charcoal shadow-primary/20'}">
                        ${confirmText}
                    </button>
                </div>
            </div>
        </div>`;

    document.body.appendChild(modal);
    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            modal.querySelector('#naomiConfirmBox').classList.remove('scale-95', 'opacity-0');
        });
    });

    const close = () => {
        const box = modal.querySelector('#naomiConfirmBox');
        box.classList.add('scale-95', 'opacity-0');
        setTimeout(() => modal.remove(), 200);
    };

    modal.querySelector('#naomiConfirmOk').addEventListener('click', () => { close(); onConfirm(); });
    modal.querySelector('#naomiConfirmCancel').addEventListener('click', close);
    modal.querySelector('#naomiConfirmBackdrop').addEventListener('click', close);
}
</script>
