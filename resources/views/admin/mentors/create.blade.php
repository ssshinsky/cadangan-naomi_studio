@extends('admin.layouts.admin')

@section('title', 'Tambah Mentor Baru')

@section('content')

    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="font-serif text-3xl font-bold text-charcoal">Tambah Mentor Baru</h2>
            <p class="text-naomi-muted text-sm mt-1">Lengkapi form di bawah untuk menambahkan mentor baru</p>
        </div>
        <a href="{{ route('admin.mentors.index') }}"
            class="text-primary hover:underline text-sm font-medium flex items-center gap-1">
            ← Kembali
        </a>
    </div>

    <form action="{{ route('admin.mentors.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.mentors._form')
    </form>

@endsection
