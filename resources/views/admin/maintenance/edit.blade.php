@extends('admin.layouts.admin')

@section('title', 'Edit Data Maintenance')

@section('content')

    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="font-serif text-3xl font-bold text-charcoal">Edit Data Maintenance</h2>
            <p class="text-naomi-muted text-sm mt-1">{{ $maintenance->cost_code }}</p>
        </div>
        <a href="{{ route('admin.maintenance.index') }}"
           class="text-primary hover:underline text-sm font-medium flex items-center gap-1">
            ← Lihat Riwayat
        </a>
    </div>

    <form action="{{ route('admin.maintenance.update', $maintenance) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.maintenance._form', ['maintenance' => $maintenance])
    </form>

@endsection
