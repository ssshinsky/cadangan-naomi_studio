<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

    {{-- Kiri: Upload Thumbnail --}}
    <div class="lg:col-span-4">
        <div class="bg-white rounded-2xl shadow-sm border border-naomi-muted/20 p-8">
            <h3 class="font-bold text-charcoal mb-5">Thumbnail Kelas</h3>

            <div id="thumbDropZone"
                 onclick="document.getElementById('thumbnailInput').click()"
                 class="relative border-2 border-dashed border-slate-200 rounded-2xl overflow-hidden hover:border-primary/50 transition-colors cursor-pointer group">
                <div class="aspect-square w-full">
                    @if(isset($class) && $class->thumbnail)
                        <img id="thumbPreview" src="{{ asset('storage/' . $class->thumbnail) }}"
                             class="absolute inset-0 w-full h-full object-cover" alt="Thumbnail">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="bg-white text-slate-900 px-3 py-1.5 rounded-lg text-xs font-bold">Ganti Foto</span>
                        </div>
                    @else
                        <div id="thumbPlaceholder" class="absolute inset-0 flex flex-col items-center justify-center gap-2">
                            <div class="bg-primary/10 size-12 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-primary">add_a_photo</span>
                            </div>
                            <p class="text-sm font-bold text-slate-600">Klik untuk upload</p>
                            <p class="text-[10px] text-slate-400">JPG, PNG · Maks. 2MB</p>
                        </div>
                        <img id="thumbPreview" src="" class="hidden absolute inset-0 w-full h-full object-cover" alt="Preview">
                    @endif
                </div>
                <input type="file" id="thumbnailInput" name="thumbnail" class="hidden" accept="image/*"
                       onchange="previewThumb(this)">
            </div>

            <p class="text-[10px] text-slate-400 mt-3 text-center">Disarankan rasio 4:5 atau 1:1</p>

            {{-- Status aktif --}}
            <div class="mt-6 flex items-center gap-3 p-4 bg-slate-50 rounded-xl">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       {{ old('is_active', isset($class) ? $class->is_active : true) ? 'checked' : '' }}
                       class="w-4 h-4 accent-primary">
                <label for="is_active" class="text-sm font-semibold text-slate-700">Tampilkan di website (Aktif)</label>
            </div>
        </div>
    </div>

    {{-- Kanan: Detail --}}
    <div class="lg:col-span-8 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-naomi-muted/20 p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-naomi-muted uppercase tracking-widest mb-2">Nama Kelas</label>
                    <input type="text" name="title" value="{{ old('title', $class->title ?? '') }}"
                           placeholder="Contoh: Private Pilates"
                           class="w-full bg-naomi-bg/20 border border-naomi-muted/20 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-naomi-muted uppercase tracking-widest mb-2">Pilih Mentor</label>
                    <select name="mentor_id"
                            class="w-full bg-naomi-bg/20 border border-naomi-muted/20 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                        <option value="">— Pilih Mentor —</option>
                        @if(isset($mentors))
                            @foreach($mentors as $mentor)
                                <option value="{{ $mentor->id }}"
                                    {{ old('mentor_id', $class->mentor_id ?? '') == $mentor->id ? 'selected' : '' }}>
                                    {{ $mentor->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('mentor_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-naomi-muted uppercase tracking-widest mb-2">Judul Lagu / Backsound</label>
                    <input type="text" name="song_title" value="{{ old('song_title', $class->song_title ?? '') }}"
                           placeholder="Contoh: Flowers - Miley Cyrus"
                           class="w-full bg-naomi-bg/20 border border-naomi-muted/20 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-naomi-muted uppercase tracking-widest mb-2">Harga (Rp)</label>
                    <input type="number" name="price" value="{{ old('price', $class->price ?? '') }}"
                           placeholder="150000" min="0"
                           class="w-full bg-naomi-bg/20 border border-naomi-muted/20 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-naomi-muted uppercase tracking-widest mb-2">Hari</label>
                    <select name="day_of_week"
                            class="w-full bg-naomi-bg/20 border border-naomi-muted/20 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                        @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $day)
                        <option value="{{ $day }}" {{ old('day_of_week', $class->day_of_week ?? '') === $day ? 'selected' : '' }}>
                            {{ $day }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-naomi-muted uppercase tracking-widest mb-2">Jam Mulai</label>
                    <input type="time" name="time_start" value="{{ old('time_start', isset($class) ? substr($class->time_start, 0, 5) : '') }}"
                           class="w-full bg-naomi-bg/20 border border-naomi-muted/20 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-naomi-muted uppercase tracking-widest mb-2">Jam Selesai</label>
                    <input type="time" name="time_end" value="{{ old('time_end', isset($class) ? substr($class->time_end, 0, 5) : '') }}"
                           class="w-full bg-naomi-bg/20 border border-naomi-muted/20 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                </div>

                <div class="md:col-span-2 border-t border-naomi-bg pt-4">
                    <label class="block text-xs font-bold text-naomi-muted uppercase tracking-widest mb-2">Deskripsi Kelas</label>
                    <textarea name="description" rows="4"
                              placeholder="Jelaskan detail kelas, apa yang didapat peserta..."
                              class="w-full bg-naomi-bg/20 border border-naomi-muted/20 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all resize-none">{{ old('description', $class->description ?? '') }}</textarea>
                </div>

                <div class="md:col-span-2 border-t border-naomi-bg pt-4">
                    <label class="block text-xs font-bold text-naomi-muted uppercase tracking-widest mb-2">Nomor WhatsApp Mentor</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-naomi-muted text-sm font-medium">+</span>
                        <input type="text" name="whatsapp_link"
                               value="{{ old('whatsapp_link', isset($class) ? ltrim(str_replace('https://wa.me/', '', $class->whatsapp_link), '/') : '') }}"
                               placeholder="628123456789"
                               class="w-full bg-naomi-bg/20 border border-naomi-muted/20 rounded-xl pl-8 pr-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                    </div>
                    <p class="text-[10px] text-slate-400 mt-1">Masukkan nomor lengkap dengan kode negara, contoh: 628123456789</p>
                    @error('whatsapp_link') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

            </div>
        </div>

        <div class="flex justify-end gap-3 pb-8">
            <a href="{{ route('admin.classes.index') }}"
               class="px-8 py-3 rounded-xl text-sm font-bold text-naomi-muted border border-naomi-muted/20 hover:bg-naomi-surface/30 transition-all">
                Batal
            </a>
            <button type="submit"
                    class="px-8 py-3 bg-primary text-white rounded-xl text-sm font-bold shadow-lg shadow-primary/20 hover:bg-charcoal transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">save</span>
                {{ isset($class) ? 'Simpan Perubahan' : 'Simpan Kelas' }}
            </button>
        </div>
    </div>

</div>

<script>
function previewThumb(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById('thumbPreview');
        const placeholder = document.getElementById('thumbPlaceholder');
        img.src = e.target.result;
        img.classList.remove('hidden');
        if (placeholder) placeholder.classList.add('hidden');
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
