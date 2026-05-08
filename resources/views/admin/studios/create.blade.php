@extends('admin.layouts.admin')

@section('title', 'Tambahkan Studio')

@section('content')
<div class="max-w-6xl mx-auto font-sans"> 
    <div class="mb-8">
        <h2 class="font-serif text-3xl font-bold text-slate-900">Tambahkan Studio</h2>
        <p class="text-slate-500 text-sm mt-1">Atur informasi, harga, dan ketersediaan ruangan studio Anda</p>
    </div>

    <form action="{{ route('admin.studios.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                    <div class="flex items-center gap-2 mb-6 text-slate-800">
                        <span class="material-symbols-outlined text-primary">info</span>
                        <h3 class="font-sans font-bold text-lg">Informasi Dasar</h3>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Studio</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all font-sans" placeholder="Contoh: Studio Besar">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Dimensi Ruangan</label>
                                <input type="text" name="size_sqm" value="{{ old('size_sqm') }}"
                                       class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none font-sans" placeholder="65m² (6,5 x 10 m)">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Maks. Kapasitas (Orang)</label>
                                <input type="number" name="capacity" value="{{ old('capacity') }}"
                                       class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none font-sans" placeholder="25">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Harga per Jam (IDR)</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-bold">Rp</span>
                                    <input type="number" name="price_per_hour" value="{{ old('price_per_hour') }}"
                                           class="w-full bg-slate-50 border-slate-200 rounded-xl pl-12 pr-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none font-sans" placeholder="60000">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Minimal DP (IDR)</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-bold">Rp</span>
                                    <input type="number" name="min_dp_amount" value="{{ old('min_dp_amount') }}"
                                           class="w-full bg-slate-50 border-slate-200 rounded-xl pl-12 pr-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none font-sans" placeholder="30000">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Tarif Extra (IDR/jam)</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-bold">Rp</span>
                                    <input type="number" name="extra_price_per_hour" value="{{ old('extra_price_per_hour') }}"
                                           class="w-full bg-slate-50 border-slate-200 rounded-xl pl-12 pr-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none font-sans" placeholder="70000">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Batas Orang (Extra)</label>
                                <input type="number" name="extra_price_threshold" value="{{ old('extra_price_threshold') }}"
                                       class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none font-sans" placeholder="20">
                                <p class="text-[10px] text-slate-400 mt-1 italic">Tarif extra berlaku jika melebihi jumlah ini</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Lantai</label>
                            <input type="text" name="floor_type" value="{{ old('floor_type') }}"
                                   class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none font-sans" placeholder="Vinyl">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Fasilitas Utama</label>
                            <textarea name="facilities" rows="3"
                                      class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none font-sans"
                                      placeholder="Lantai Vinyl, Cermin, Bluetooth Speaker, Tripod">{{ old('facilities') }}</textarea>
                            <p class="text-[10px] text-slate-400 mt-2 italic">Pisahkan dengan koma (,)</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Studio</label>
                            <textarea name="description" rows="3"
                                      class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none font-sans"
                                      placeholder="Deskripsi singkat studio...">{{ old('description') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Peraturan & Ketentuan</label>
                            <textarea name="rules" rows="5"
                                      class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none font-sans"
                                      placeholder="Contoh:&#10;- Dilarang merokok di dalam ruangan&#10;- Wajib menggunakan alas kaki yang sesuai&#10;- Tidak diperkenankan membawa makanan berat">{{ old('rules') }}</textarea>
                            <p class="text-[10px] text-slate-400 mt-1 italic">Tulis tiap aturan di baris baru, awali dengan tanda - atau nomor</p>
                        </div>

                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="is_available" id="is_available" checked class="w-4 h-4 accent-primary">
                            <label for="is_available" class="text-sm font-semibold text-slate-700">Tampilkan di website (Aktif)</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center gap-2 text-slate-800">
                            <span class="material-symbols-outlined text-primary text-xl">gallery_thumbnail</span>
                            <h3 class="font-sans font-bold">Foto Studio</h3>
                        </div>
                        <span id="photoCount" class="text-[10px] font-bold text-slate-400 bg-slate-100 px-3 py-1 rounded-full">0 foto</span>
                    </div>

                    {{-- Foto Utama --}}
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Foto Utama</p>
                    <div id="primaryDropZone"
                         onclick="document.getElementById('primaryImageInput').click()"
                         class="relative border-2 border-dashed border-slate-200 rounded-2xl overflow-hidden hover:border-primary/50 transition-colors cursor-pointer group mb-5">
                        {{-- Ratio 4:3 --}}
                        <div class="aspect-[4/3] w-full">
                            <div id="primaryPlaceholder" class="absolute inset-0 flex flex-col items-center justify-center gap-2">
                                <div class="bg-primary/10 size-12 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <span class="material-symbols-outlined text-primary">upload_file</span>
                                </div>
                                <p class="text-sm font-bold text-slate-600">Klik untuk upload</p>
                                <p class="text-[10px] text-slate-400">PNG, JPG · Maks. 5MB · Rasio 4:3</p>
                            </div>
                            <img id="primaryPreviewImg" src="" alt="Preview"
                                 class="hidden absolute inset-0 w-full h-full object-cover">
                            <div id="primaryOverlay" class="hidden absolute inset-0 bg-black/40 items-center justify-center">
                                <span class="bg-white text-slate-900 px-3 py-1.5 rounded-lg text-xs font-bold flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">cached</span> Ganti
                                </span>
                            </div>
                        </div>
                        <input type="file" id="primaryImageInput" name="primary_image" class="hidden" accept="image/*"
                               onchange="previewPrimary(this)">
                    </div>

                    {{-- Foto Tambahan --}}
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Foto Tambahan</p>
                        <span class="text-[10px] text-slate-400">Opsional · maks. 8 foto</span>
                    </div>

                    {{-- Grid foto tambahan --}}
                    <div id="extraGrid" class="grid grid-cols-3 gap-2 mb-3"></div>

                    {{-- Tombol tambah --}}
                    <div id="addMoreBtn"
                         onclick="document.getElementById('extraImagesInput').click()"
                         class="border-2 border-dashed border-slate-200 rounded-xl p-3 text-center hover:border-primary/50 transition-colors cursor-pointer flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-slate-300 text-xl">add_photo_alternate</span>
                        <p class="text-xs text-slate-400 font-medium">Tambah foto</p>
                        <input type="file" id="extraImagesInput" name="extra_images[]" class="hidden" accept="image/*" multiple
                               onchange="addExtraImages(this)">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-8">
            <a href="{{ route('admin.studios.index') }}" class="px-8 py-3 bg-white border border-slate-200 text-slate-600 rounded-xl font-sans font-bold text-sm hover:bg-slate-50 transition-all">
                Batal
            </a>
            <button type="submit" class="flex items-center gap-2 px-8 py-3 bg-primary text-white rounded-xl font-sans font-bold text-sm shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                <span class="material-symbols-outlined text-sm">save</span>
                Simpan Studio
            </button>
        </div>
    </form>
</div>

<script>
let extraFiles = [];

function updatePhotoCount() {
    const hasPrimary = !document.getElementById('primaryPreviewImg').classList.contains('hidden') ? 1 : 0;
    const total = hasPrimary + extraFiles.length;
    document.getElementById('photoCount').textContent = total + ' foto';
}

function previewPrimary(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById('primaryPreviewImg');
        const placeholder = document.getElementById('primaryPlaceholder');
        const overlay = document.getElementById('primaryOverlay');
        img.src = e.target.result;
        img.classList.remove('hidden');
        placeholder.classList.add('hidden');
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');
        updatePhotoCount();
    };
    reader.readAsDataURL(input.files[0]);
}

function addExtraImages(input) {
    const MAX = 8;
    const grid = document.getElementById('extraGrid');
    Array.from(input.files).forEach(file => {
        if (extraFiles.length >= MAX) return;
        extraFiles.push(file);
        const reader = new FileReader();
        const idx = extraFiles.length - 1;
        reader.onload = e => {
            const div = document.createElement('div');
            div.className = 'relative group aspect-[4/3] rounded-xl overflow-hidden border border-slate-200';
            div.dataset.idx = idx;
            div.innerHTML = `
                <img src="${e.target.result}" class="w-full h-full object-cover">
                <button type="button" onclick="removeExtra(${idx})"
                    class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow">
                    <span class="material-symbols-outlined text-xs leading-none">close</span>
                </button>`;
            grid.appendChild(div);
            updatePhotoCount();
        };
        reader.readAsDataURL(file);
    });
    // Reset input so same files can be re-added after removal
    input.value = '';
}

function removeExtra(idx) {
    extraFiles[idx] = null;
    const grid = document.getElementById('extraGrid');
    const item = grid.querySelector(`[data-idx="${idx}"]`);
    if (item) item.remove();
    updatePhotoCount();
    syncExtraInput();
}

function syncExtraInput() {
    // Rebuild a DataTransfer to keep the file input in sync
    const dt = new DataTransfer();
    extraFiles.filter(Boolean).forEach(f => dt.items.add(f));
    document.getElementById('extraImagesInput').files = dt.files;
}
</script>
@endsection