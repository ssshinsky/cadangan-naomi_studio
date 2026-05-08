@extends('admin.layouts.admin')

@section('title', 'Edit Kelas')

@section('content')

    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="font-serif text-3xl font-bold text-charcoal">Edit Kelas</h2>
            <p class="text-naomi-muted text-sm mt-1">Perbarui informasi kelas {{ $class->title }}</p>
        </div>
        <a href="{{ route('admin.classes.index') }}"
            class="text-primary hover:underline text-sm font-medium flex items-center gap-1">
            ← Kembali
        </a>
    </div>

    <form action="{{ route('admin.classes.update', $class) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.classes._form', ['class' => $class])
    </form>

@endsection
