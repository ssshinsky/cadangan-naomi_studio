@extends('admin.layouts.admin')

@section('title', 'Buat Closure Studio')

@section('content')

<div class="max-w-3xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="font-serif text-3xl font-bold text-slate-900">Buat Closure Studio</h2>
            <p class="text-slate-500 text-sm mt-1">Tutup studio untuk rentang jam tertentu agar tidak bisa dipesan customer</p>
        </div>
        <a href="{{ route('admin.closures.index') }}"
           class="text-primary hover:underline text-sm font-medium flex items-center gap-1">
            ← Kembali ke Daftar
        </a>
    </div>

    {{-- Panel Peringatan Konflik Booking --}}
    @if(session('conflictingBookings') && count(session('conflictingBookings')) > 0)
    <div class="mb-6 bg-amber-50 border border-amber-200 rounded-2xl p-6">
        <div class="flex items-start gap-3 mb-4">
            <span class="material-symbols-outlined text-amber-500 text-2xl mt-0.5">warning</span>
            <div>
                <h3 class="font-bold text-amber-800 text-base">Peringatan: Ada Booking yang Terdampak</h3>
                <p class="text-amber-700 text-sm mt-1">
                    Closure ini akan bertumpang-tindih dengan
                    <strong>{{ count(session('conflictingBookings')) }} booking</strong> yang sudah ada.
                    Apakah Anda tetap ingin melanjutkan?
                </p>
            </div>
        </div>

        {{-- Tabel daftar booking terdampak --}}
        <div class="overflow-x-auto rounded-xl border border-amber-200 mb-5">
            <table class="w-full text-sm">
                <thead class="bg-amber-100 text-amber-800">
                    <tr>
                        <th class="text-left px-4 py-3 font-semibold">Kode Booking</th>
                        <th class="text-left px-4 py-3 font-semibold">Customer</th>
                        <th class="text-left px-4 py-3 font-semibold">Jam Mulai</th>
                        <th class="text-left px-4 py-3 font-semibold">Jam Selesai</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-amber-100">
                    @foreach(session('conflictingBookings') as $booking)
                    <tr class="bg-white hover:bg-amber-50 transition-colors">
                        <td class="px-4 py-3 font-mono font-semibold text-slate-700">
                            {{ $booking['booking_code'] ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-slate-600">
                            {{ $booking['customer_name'] ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-slate-600">
                            {{ \Illuminate\Support\Str::substr($booking['start_time'] ?? '-', 0, 5) }}
                        </td>
                        <td class="px-4 py-3 text-slate-600">
                            {{ \Illuminate\Support\Str::substr($booking['end_time'] ?? '-', 0, 5) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Tombol konfirmasi: POST ke confirm-store dengan hidden fields --}}
        <div class="flex items-center gap-3">
            <form action="{{ route('admin.closures.confirm-store') }}" method="POST" class="flex-1">
                @csrf
                <input type="hidden" name="studio_id"  value="{{ old('studio_id') }}">
                <input type="hidden" name="date"        value="{{ old('date') }}">
                <input type="hidden" name="start_time"  value="{{ old('start_time') }}">
                <input type="hidden" name="end_time"    value="{{ old('end_time') }}">
                <input type="hidden" name="reason"      value="{{ old('reason') }}">

                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white rounded-xl font-bold text-sm shadow-lg shadow-amber-500/20 transition-all">
                    <span class="material-symbols-outlined text-sm">check_circle</span>
                    Ya, Tetap Buat Closure
                </button>
            </form>

            <a href="{{ route('admin.closures.create') }}"
               class="px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-50 transition-all whitespace-nowrap">
                Batalkan
            </a>
        </div>
    </div>
    @endif

    {{-- Form Utama --}}
    <form action="{{ route('admin.closures.store') }}" method="POST">
        @csrf

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">

            <div class="flex items-center gap-2 mb-6 text-slate-800">
                <span class="material-symbols-outlined text-primary">event_busy</span>
                <h3 class="font-bold text-lg">Detail Closure</h3>
            </div>

            <div class="space-y-5">

                {{-- Dropdown Studio --}}
                <div>
                    <label for="studio_id" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">
                        Studio <span class="text-red-400">*</span>
                    </label>
                    <select name="studio_id" id="studio_id"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all
                                   {{ $errors->has('studio_id') ? 'border-red-400 bg-red-50' : '' }}">
                        <option value="">— Pilih Studio —</option>
                        @foreach($studios as $studio)
                            <option value="{{ $studio->id }}" {{ old('studio_id', request('studio_id')) == $studio->id ? 'selected' : '' }}>
                                {{ $studio->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('studio_id')
                        <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                            <span class="material-symbols-outlined text-xs">error</span>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Date Picker --}}
                <div>
                    <label for="date" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">
                        Tanggal <span class="text-red-400">*</span>
                    </label>
                    <input type="date" name="date" id="date"
                           value="{{ old('date', request('date')) }}"
                           min="{{ now()->format('Y-m-d') }}"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all
                                  {{ $errors->has('date') ? 'border-red-400 bg-red-50' : '' }}">
                    @error('date')
                        <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                            <span class="material-symbols-outlined text-xs">error</span>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Jam Mulai & Jam Selesai --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="start_time" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">
                            Jam Mulai <span class="text-red-400">*</span>
                        </label>
                        <input type="time" name="start_time" id="start_time"
                               value="{{ old('start_time', request('start_time')) }}"
                               step="3600"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all
                                      {{ $errors->has('start_time') ? 'border-red-400 bg-red-50' : '' }}">
                        @error('start_time')
                            <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">error</span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_time" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">
                            Jam Selesai <span class="text-red-400">*</span>
                        </label>
                        <input type="time" name="end_time" id="end_time"
                               value="{{ old('end_time', request('end_time')) }}"
                               step="3600"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all
                                      {{ $errors->has('end_time') ? 'border-red-400 bg-red-50' : '' }}">
                        @error('end_time')
                            <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">error</span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                {{-- Reason Textarea --}}
                <div>
                    <label for="reason" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">
                        Alasan Penutupan <span class="text-red-400">*</span>
                    </label>
                    <textarea name="reason" id="reason" rows="3"
                              maxlength="255"
                              placeholder="Contoh: Maintenance AC, Event internal, Libur nasional..."
                              class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all resize-none
                                     {{ $errors->has('reason') ? 'border-red-400 bg-red-50' : '' }}">{{ old('reason') }}</textarea>
                    <div class="flex items-start justify-between mt-1">
                        @error('reason')
                            <p class="text-red-500 text-xs flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">error</span>
                                {{ $message }}
                            </p>
                        @else
                            <span></span>
                        @enderror
                        <span class="text-slate-400 text-xs">maks. 255 karakter</span>
                    </div>
                </div>

            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('admin.closures.index') }}"
               class="px-8 py-3 bg-white border border-slate-200 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-50 transition-all">
                Batal
            </a>
            <button type="submit"
                    class="flex items-center gap-2 px-8 py-3 bg-primary text-white rounded-xl font-bold text-sm shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                <span class="material-symbols-outlined text-sm">event_busy</span>
                Buat Closure
            </button>
        </div>

    </form>
</div>

@endsection
