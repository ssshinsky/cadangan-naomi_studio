@php
$config = match($status) {
    'verified' => match($type ?? 'full') {
        'dp', 'pelunasan' => ['label' => 'DP',    'class' => 'bg-amber-50 text-amber-600 border-amber-200'],
        default           => ['label' => 'LUNAS', 'class' => 'bg-blue-50 text-blue-600 border-blue-200'],
    },
    'pending'  => ['label' => 'MENUNGGU VERIFIKASI', 'class' => 'bg-slate-100 text-slate-500 border-slate-200'],
    'rejected' => ['label' => 'DITOLAK',             'class' => 'bg-red-50 text-red-600 border-red-200'],
    default    => ['label' => strtoupper($status),   'class' => 'bg-slate-100 text-slate-500 border-slate-200'],
};
@endphp
<span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border whitespace-nowrap {{ $config['class'] }}">
    {{ $config['label'] }}
</span>
