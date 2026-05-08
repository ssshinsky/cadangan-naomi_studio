@extends('admin.layouts.admin')

@section('title', 'Edit Mentor')

@section('content')

    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="font-serif text-3xl font-bold text-charcoal">Edit Mentor</h2>
            <p class="text-naomi-muted text-sm mt-1">Perbarui informasi mentor {{ $mentor->name }}</p>
        </div>
        <a href="{{ route('admin.mentors.index') }}"
            class="text-primary hover:underline text-sm font-medium flex items-center gap-1">
            ← Kembali
        </a>
    </div>

    <form action="{{ route('admin.mentors.update', $mentor) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.mentors._form', ['mentor' => $mentor])
    </form>

@endsection
