<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

    {{-- Kiri: Upload Foto --}}
    <div class="lg:col-span-4">
        <div class="bg-white rounded-2xl shadow-sm border border-naomi-muted/20 p-8">
            <h3 class="font-bold text-charcoal mb-5">Foto Mentor</h3>

            <div id="photoDropZone"
                 onclick="document.getElementById('photoInput').click()"
                 class="relative border-2 border-dashed border-slate-200 rounded-2xl overflow-hidden hover:border-primary/50 transition-colors cursor-pointer group">
                <div class="aspect-square w-full">
                    @if(isset($mentor) && $mentor->photo)
                        <img id="photoPreview" src="{{ asset('storage/' . $mentor->photo) }}"
                             class="absolute inset-0 w-full h-full object-cover" alt="{{ $mentor->name }}">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="bg-white text-slate-900 px-3 py-1.5 rounded-lg text-xs font-bold">Ganti Foto</span>
                        </div>
                    @else
                        <div id="photoPlaceholder" class="absolute inset-0 flex flex-col items-center justify-center gap-2">
                            <div class="bg-primary/10 size-12 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-primary">add_a_photo</span>
                            </div>
                            <p class="text-sm font-bold text-slate-600">Klik untuk upload</p>
                            <p class="text-[10px] text-slate-400">JPG, PNG · Maks. 2MB</p>
                        </div>
                        <img id="photoPreview" src="" class="hidden absolute inset-0 w-full h-full object-cover" alt="Preview">
                    @endif
                </div>
                <input type="file" id="photoInput" name="photo" class="hidden" accept="image/*"
                       onchange="previewPhoto(this)">
            </div>

            @error('photo')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
            <p class="text-[10px] text-slate-400 mt-3 text-center">Disarankan rasio 1:1 (foto profil)</p>
        </div>
    </div>

    {{-- Kanan: Detail --}}
    <div class="lg:col-span-8 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-naomi-muted/20 p-8">
            <div class="space-y-6">

                <div>
                    <label class="block text-xs font-bold text-naomi-muted uppercase tracking-widest mb-2">
                        Nama Mentor <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $mentor->name ?? '') }}"
                           placeholder="Contoh: Sarah Wijaya"
                           class="w-full bg-naomi-bg/20 border border-naomi-muted/20 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-naomi-muted uppercase tracking-widest mb-2">Bio</label>
                    <textarea name="bio" rows="3"
                              placeholder="Ceritakan sedikit tentang mentor ini..."
                              class="w-full bg-naomi-bg/20 border border-naomi-muted/20 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all resize-none">{{ old('bio', $mentor->bio ?? '') }}</textarea>
                    @error('bio') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-naomi-muted uppercase tracking-widest mb-2">Pengalaman</label>
                    <textarea name="experience" rows="3"
                              placeholder="Contoh: 5 tahun mengajar pilates, bersertifikat internasional..."
                              class="w-full bg-naomi-bg/20 border border-naomi-muted/20 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all resize-none">{{ old('experience', $mentor->experience ?? '') }}</textarea>
                    @error('experience') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-naomi-muted uppercase tracking-widest mb-2">Keunggulan</label>
                    <textarea name="expertise" rows="3"
                              placeholder="Contoh: Spesialis yoga prenatal, ahli meditasi mindfulness..."
                              class="w-full bg-naomi-bg/20 border border-naomi-muted/20 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all resize-none">{{ old('expertise', $mentor->expertise ?? '') }}</textarea>
                    @error('expertise') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

            </div>
        </div>

        <div class="flex justify-end gap-3 pb-8">
            <a href="{{ route('admin.mentors.index') }}"
               class="px-8 py-3 rounded-xl text-sm font-bold text-naomi-muted border border-naomi-muted/20 hover:bg-naomi-surface/30 transition-all">
                Batal
            </a>
            <button type="submit"
                    class="px-8 py-3 bg-primary text-white rounded-xl text-sm font-bold shadow-lg shadow-primary/20 hover:bg-charcoal transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">save</span>
                {{ isset($mentor) ? 'Simpan Perubahan' : 'Simpan Mentor' }}
            </button>
        </div>
    </div>

</div>

<script>
function previewPhoto(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById('photoPreview');
        const placeholder = document.getElementById('photoPlaceholder');
        img.src = e.target.result;
        img.classList.remove('hidden');
        if (placeholder) placeholder.classList.add('hidden');
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
