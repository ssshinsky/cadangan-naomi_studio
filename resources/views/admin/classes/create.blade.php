@extends('admin.layouts.admin')

@section('title', 'Tambah Kelas Baru')

@section('content')

    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="font-serif text-3xl font-bold text-charcoal">Tambah Kelas Baru</h2>
            <p class="text-naomi-muted text-sm mt-1">Lengkapi form di bawah untuk menambahkan kelas promosi baru</p>
        </div>
        <a href="{{ route('admin.classes.index') }}"
            class="text-primary hover:underline text-sm font-medium flex items-center gap-1">
            ← Kembali
        </a>
    </div>

    <form action="{{ route('admin.classes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.classes._form')
    </form>

@endsection
