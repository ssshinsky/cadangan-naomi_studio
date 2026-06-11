@extends('admin.layouts.admin')

@section('title', 'Edit Detail Studio')

@section('content')
<div class="max-w-6xl mx-auto font-sans">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="font-serif text-3xl font-bold text-slate-900">Edit Detail Studio</h2>
            <p class="text-slate-500 text-sm mt-1">Perbarui informasi ruangan {{ $studio->name }}</p>
        </div>
        <div class="flex items-center gap-2 px-4 py-2 {{ $studio->is_available ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-slate-100 text-slate-500 border-slate-200' }} rounded-full border">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $studio->is_available ? 'bg-emerald-400' : 'bg-slate-400' }} opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 {{ $studio->is_available ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
            </span>
            <span class="text-xs font-bold uppercase tracking-wider">{{ $studio->is_available ? 'Aktif' : 'Nonaktif' }}</span>
        </div>
    </div>

    @if(session('success'))
    @endif

    <form action="{{ route('admin.studios.update', $studio->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                    <div class="flex items-center gap-2 mb-6 text-slate-800">
                        <span class="material-symbols-outlined text-primary">edit_note</span>
                        <h3 class="font-sans font-bold text-lg">Informasi Ruangan</h3>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Studio</label>
                            <input type="text" name="name" value="{{ old('name', $studio->name) }}"
                                   class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none font-sans">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Dimensi Ruangan</label>
                                <input type="text" name="size_sqm" value="{{ old('size_sqm', $studio->size_sqm) }}"
                                       class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none font-sans">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Maks. Kapasitas</label>
                                <input type="number" name="capacity" value="{{ old('capacity', $studio->capacity) }}"
                                       class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none font-sans">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Harga per Jam (IDR)</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-bold">Rp</span>
                                    <input type="number" name="price_per_hour" value="{{ old('price_per_hour', $studio->price_per_hour) }}"
                                           class="w-full bg-slate-50 border-slate-200 rounded-xl pl-12 pr-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none font-sans">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Minimal DP (IDR)</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-bold">Rp</span>
                                    <input type="number" name="min_dp_amount" value="{{ old('min_dp_amount', $studio->min_dp_amount) }}"
                                           class="w-full bg-slate-50 border-slate-200 rounded-xl pl-12 pr-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none font-sans">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Tarif Extra (IDR/jam)</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-bold">Rp</span>
                                    <input type="number" name="extra_price_per_hour" value="{{ old('extra_price_per_hour', $studio->extra_price_per_hour) }}"
                                           class="w-full bg-slate-50 border-slate-200 rounded-xl pl-12 pr-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none font-sans">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Batas Orang (Extra)</label>
                                <input type="number" name="extra_price_threshold" value="{{ old('extra_price_threshold', $studio->extra_price_threshold) }}"
                                       class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none font-sans">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Lantai</label>
                            <input type="text" name="floor_type" value="{{ old('floor_type', $studio->floor_type) }}"
                                   class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none font-sans">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Fasilitas Utama</label>
                            <textarea name="facilities" rows="3"
                                      class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none font-sans">{{ old('facilities', $studio->facilities->pluck('name')->join(', ')) }}</textarea>
                            <p class="text-[10px] text-slate-400 mt-2 italic">Pisahkan dengan koma (,)</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Studio</label>
                            <textarea name="description" rows="3"
                                      class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none font-sans">{{ old('description', $studio->description) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Peraturan & Ketentuan</label>
                            <textarea name="rules" rows="5"
                                      class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none font-sans"
                                      placeholder="Contoh:&#10;- Dilarang merokok di dalam ruangan&#10;- Wajib menggunakan alas kaki yang sesuai">{{ old('rules', $studio->rules) }}</textarea>
                            <p class="text-[10px] text-slate-400 mt-1 italic">Tulis tiap aturan di baris baru, awali dengan tanda - atau nomor</p>
                        </div>

                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="is_available" id="is_available"
                                   {{ $studio->is_available ? 'checked' : '' }} class="w-4 h-4 accent-primary">
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
                            <h3 class="font-sans font-bold">Media Studio</h3>
                        </div>
                        <span id="photoCount" class="text-[10px] font-bold text-slate-400 bg-slate-100 px-3 py-1 rounded-full">
                            {{ $studio->images->count() }} foto
                        </span>
                    </div>

                    {{-- Foto Utama --}}
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Foto Utama</p>
                    <div id="primaryDropZone"
                         onclick="document.getElementById('primaryImageInput').click()"
                         class="relative border-2 border-dashed border-slate-200 rounded-2xl overflow-hidden hover:border-primary/50 transition-colors cursor-pointer group mb-5">
                        <div class="aspect-[4/3] w-full">
                            @if($studio->primaryImage)
                                <div id="primaryPlaceholder" class="hidden absolute inset-0 flex flex-col items-center justify-center gap-2">
                                    <div class="bg-primary/10 size-12 rounded-full flex items-center justify-center">
                                        <span class="material-symbols-outlined text-primary">upload_file</span>
                                    </div>
                                    <p class="text-sm font-bold text-slate-600">Klik untuk upload</p>
                                    <p class="text-[10px] text-slate-400">PNG, JPG · Maks. 5MB · Rasio 4:3</p>
                                </div>
                                <img id="primaryPreviewImg" src="{{ asset('storage/' . $studio->primaryImage->image_url) }}"
                                     alt="Preview" class="absolute inset-0 w-full h-full object-cover">
                            @else
                                <div id="primaryPlaceholder" class="absolute inset-0 flex flex-col items-center justify-center gap-2">
                                    <div class="bg-primary/10 size-12 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <span class="material-symbols-outlined text-primary">upload_file</span>
                                    </div>
                                    <p class="text-sm font-bold text-slate-600">Klik untuk upload</p>
                                    <p class="text-[10px] text-slate-400">PNG, JPG · Maks. 5MB · Rasio 4:3</p>
                                </div>
                                <img id="primaryPreviewImg" src="" alt="Preview"
                                     class="hidden absolute inset-0 w-full h-full object-cover">
                            @endif
                            <div id="primaryOverlay" class="absolute inset-0 bg-black/40 {{ $studio->primaryImage ? 'opacity-0 group-hover:opacity-100' : 'hidden' }} transition-opacity flex items-center justify-center">
                                <span class="bg-white text-slate-900 px-3 py-1.5 rounded-lg text-xs font-bold flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">cached</span> Ganti Foto Utama
                                </span>
                            </div>
                        </div>
                        <input type="file" id="primaryImageInput" name="primary_image" class="hidden" accept="image/*"
                               onchange="previewPrimary(this)">
                    </div>

                    {{-- Foto Tambahan --}}
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Foto Tambahan</p>
                        <span class="text-[10px] text-slate-400">Hover → klik X untuk hapus</span>
                    </div>

                    <div id="extraGrid" class="grid grid-cols-3 gap-2 mb-3">
                        @php $extraImages = $studio->images->where('is_primary', false); @endphp
                        @foreach($extraImages as $img)
                        <div class="relative group aspect-[4/3] rounded-xl overflow-hidden border border-slate-200" data-existing="{{ $img->id }}">
                            <img src="{{ asset('storage/' . $img->image_url) }}" class="w-full h-full object-cover">
                            <label class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center cursor-pointer opacity-0 group-hover:opacity-100 transition-opacity shadow">
                                <input type="checkbox" name="delete_images[]" value="{{ $img->id }}" class="hidden delete-cb">
                                <span class="material-symbols-outlined text-xs leading-none">close</span>
                            </label>
                        </div>
                        @endforeach
                    </div>

                    {{-- Tombol tambah --}}
                    <div onclick="document.getElementById('extraImagesInput').click()"
                         class="border-2 border-dashed border-slate-200 rounded-xl p-3 text-center hover:border-primary/50 transition-colors cursor-pointer flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-slate-300 text-xl">add_photo_alternate</span>
                        <p class="text-xs text-slate-400 font-medium">Tambah foto baru</p>
                        <input type="file" id="extraImagesInput" name="extra_images[]" class="hidden" accept="image/*" multiple
                               onchange="addExtraImages(this)">
                    </div>
                    <div id="newExtraGrid" class="grid grid-cols-3 gap-2 mt-2"></div>
                </div>

                {{-- VIDEO STUDIO --}}
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                    <div class="flex items-center gap-2 mb-4 text-slate-800">
                        <span class="material-symbols-outlined text-primary text-xl">videocam</span>
                        <h3 class="font-sans font-bold">Video Studio</h3>
                        <span class="text-[10px] text-slate-400 ml-auto">MP4/MOV/WebM · Maks. 100MB</span>
                    </div>

                    @if($studio->video)
                    <div class="mb-3">
                        <video src="{{ asset('storage/' . $studio->video) }}"
                               class="w-full aspect-video object-cover rounded-2xl" controls muted playsinline id="currentVideo"></video>
                        <div class="flex items-center justify-between mt-2">
                            <p class="text-[10px] text-slate-500 font-bold">Video saat ini</p>
                            <label class="flex items-center gap-1.5 cursor-pointer text-[10px] text-red-500 font-bold">
                                <input type="checkbox" name="delete_video" value="1" id="deleteVideoCheck"
                                       class="w-3 h-3 accent-red-500"
                                       onchange="toggleDeleteVideo(this)">
                                Hapus video ini
                            </label>
                        </div>
                    </div>
                    @endif

                    <div id="videoDropZone"
                         onclick="document.getElementById('videoInput').click()"
                         class="relative border-2 border-dashed border-slate-200 rounded-2xl overflow-hidden hover:border-primary/50 transition-colors cursor-pointer group {{ $studio->video ? 'mt-3' : '' }}">
                        <div class="aspect-video w-full bg-slate-50 flex flex-col items-center justify-center gap-2" id="videoPlaceholder">
                            <div class="bg-primary/10 size-12 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-primary">upload</span>
                            </div>
                            <p class="text-sm font-bold text-slate-600">{{ $studio->video ? 'Ganti video' : 'Klik untuk upload video' }}</p>
                            <p class="text-[10px] text-slate-400">MP4, MOV, WebM · Maks. 100MB</p>
                        </div>
                        <video id="videoPreview" class="hidden w-full aspect-video object-cover" controls muted playsinline></video>
                    </div>
                    <input type="file" id="videoInput" name="video" class="hidden" accept="video/mp4,video/quicktime,video/webm,video/x-msvideo"
                           onchange="previewVideo(this)">
                    <p id="videoFileName" class="text-[10px] text-primary font-bold mt-2 hidden"></p>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-8">
            <a href="{{ route('admin.studios.index') }}"
               class="px-8 py-3 bg-white border border-slate-200 text-slate-600 rounded-xl font-sans font-bold text-sm hover:bg-slate-50 transition-all">
                Batalkan Perubahan
            </a>
            <button type="submit"
                    class="flex items-center gap-2 px-8 py-3 bg-primary text-white rounded-xl font-sans font-bold text-sm shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all">
                <span class="material-symbols-outlined text-sm">check_circle</span>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
let newExtraFiles = [];

function updatePhotoCount() {
    const existingVisible = document.querySelectorAll('#extraGrid [data-existing]:not(.marked-delete)').length;
    const hasPrimary = document.getElementById('primaryPreviewImg') &&
                       !document.getElementById('primaryPreviewImg').classList.contains('hidden') ? 1 :
                       (document.querySelector('#primaryDropZone img:not(.hidden)') ? 1 : 0);
    const total = (hasPrimary ? 1 : 0) + existingVisible + newExtraFiles.filter(Boolean).length;
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
        overlay.classList.remove('opacity-0');
        overlay.classList.add('opacity-100');
        updatePhotoCount();
    };
    reader.readAsDataURL(input.files[0]);
}

function addExtraImages(input) {
    const MAX = 8;
    const grid = document.getElementById('newExtraGrid');
    Array.from(input.files).forEach(file => {
        if (newExtraFiles.filter(Boolean).length >= MAX) return;
        newExtraFiles.push(file);
        const idx = newExtraFiles.length - 1;
        const reader = new FileReader();
        reader.onload = e => {
            const div = document.createElement('div');
            div.className = 'relative group aspect-[4/3] rounded-xl overflow-hidden border border-slate-200';
            div.dataset.newIdx = idx;
            div.innerHTML = `
                <img src="${e.target.result}" class="w-full h-full object-cover">
                <button type="button" onclick="removeNewExtra(${idx})"
                    class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow">
                    <span class="material-symbols-outlined text-xs leading-none">close</span>
                </button>`;
            grid.appendChild(div);
            updatePhotoCount();
        };
        reader.readAsDataURL(file);
    });
    input.value = '';
}

function removeNewExtra(idx) {
    newExtraFiles[idx] = null;
    const grid = document.getElementById('newExtraGrid');
    const item = grid.querySelector(`[data-new-idx="${idx}"]`);
    if (item) item.remove();
    syncExtraInput();
    updatePhotoCount();
}

function syncExtraInput() {
    const dt = new DataTransfer();
    newExtraFiles.filter(Boolean).forEach(f => dt.items.add(f));
    document.getElementById('extraImagesInput').files = dt.files;
}

// Toggle hapus foto existing
document.querySelectorAll('.delete-cb').forEach(cb => {
    cb.closest('label').addEventListener('click', function(e) {
        e.preventDefault();
        cb.checked = !cb.checked;
        const container = cb.closest('[data-existing]');
        if (cb.checked) {
            container.classList.add('marked-delete');
            container.style.opacity = '0.35';
            this.style.opacity = '1';
        } else {
            container.classList.remove('marked-delete');
            container.style.opacity = '1';
        }
        updatePhotoCount();
    });
});

function previewVideo(input) {
    if (!input.files || !input.files[0]) return;
    const file = input.files[0];
    const url = URL.createObjectURL(file);
    const video = document.getElementById('videoPreview');
    const placeholder = document.getElementById('videoPlaceholder');
    const fileName = document.getElementById('videoFileName');
    video.src = url;
    video.classList.remove('hidden');
    placeholder.classList.add('hidden');
    fileName.textContent = file.name;
    fileName.classList.remove('hidden');
}

function toggleDeleteVideo(cb) {
    const currentVideo = document.getElementById('currentVideo');
    if (currentVideo) {
        currentVideo.style.opacity = cb.checked ? '0.3' : '1';
    }
}
</script>
@endsection
