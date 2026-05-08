@extends('admin.layouts.admin')

@section('title', 'Tambah Biaya Maintenance')

@section('content')

    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="font-serif text-3xl font-bold text-charcoal">Input Maintenance</h2>
            <p class="text-naomi-muted text-sm mt-1">Catat pengeluaran rutin bulanan studio di sini</p>
        </div>
        <a href="{{ route('admin.maintenance.index') }}"
           class="text-primary hover:underline text-sm font-medium flex items-center gap-1">
            ← Lihat Riwayat
        </a>
    </div>

    <form action="{{ route('admin.maintenance.store') }}" method="POST">
        @csrf
        @include('admin.maintenance._form')
    </form>

@endsection
