@extends('layouts.app')

@section('title', 'Edit Profil - Naomi Studio')

@section('content')
<main class="bg-naomi-bg min-h-screen pb-20">
    <div class="max-w-7xl mx-auto px-6 py-20">
        <div class="flex flex-col lg:flex-row gap-10">

            {{-- SIDEBAR --}}
            <div class="w-full lg:w-72 shrink-0">
                <div class="bg-naomi-white rounded-[2.5rem] p-8 shadow-sm border border-charcoal/10">
                    <div class="flex items-center gap-4 mb-10 pb-6 border-b border-naomi-bg">
                        <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-primary/20">
                            @if($customer->avatar)
                                <img src="{{ asset('storage/' . $customer->avatar) }}" class="w-full h-full object-cover" alt="Avatar">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&background=2D2A28&color=fff&bold=true"
                                     class="w-full h-full object-cover" alt="Avatar">
                            @endif
                        </div>
                        <div>
                            <p class="font-black text-charcoal leading-tight">{{ $customer->name }}</p>
                            <p class="text-[10px] text-charcoal/40 uppercase tracking-widest mt-1 font-bold">Member</p>
                        </div>
                    </div>

                    <nav class="space-y-2">
                        <a href="{{ route('profil') }}"
                           class="flex items-center gap-3 px-4 py-4 bg-primary text-naomi-white rounded-2xl font-black text-[11px] uppercase tracking-wider shadow-lg shadow-primary/20 whitespace-nowrap">
                            <span class="material-symbols-outlined text-lg shrink-0">person</span>
                            Profil Saya
                        </a>
                        <a href="{{ route('profil.riwayat-booking') }}"
                           class="flex items-center gap-3 px-4 py-4 hover:bg-naomi-bg rounded-2xl text-charcoal/60 font-black text-[11px] uppercase tracking-wider transition-all whitespace-nowrap">
                            <span class="material-symbols-outlined text-lg shrink-0">history</span>
                            Riwayat Booking
                        </a>
                        <div class="pt-6 border-t border-naomi-bg mt-4">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-4 text-red-500/60 hover:text-red-500 hover:bg-red-50 rounded-2xl font-black text-[11px] uppercase tracking-wider transition-all">
                                    <span class="material-symbols-outlined text-lg shrink-0">logout</span>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </nav>
                </div>
            </div>

            {{-- MAIN CONTENT --}}
            <div class="flex-1">
                <div class="bg-naomi-white rounded-[3rem] p-10 shadow-sm border border-charcoal/10">

                    <div class="flex flex-col md:flex-row justify-between items-center md:items-start gap-6 mb-12">
                        <div>
                            <h1 class="serif-title text-4xl md:text-5xl font-bold text-charcoal tracking-tighter">Edit Profil</h1>
                            <p class="text-charcoal/50 mt-2 font-medium">Kelola informasi profil dan detail kontak Anda</p>
                        </div>
                        <a href="{{ route('profil') }}"
                           class="text-primary hover:text-charcoal text-xs font-black uppercase tracking-widest flex items-center gap-2 transition-all">
                            <span class="material-symbols-outlined text-sm">arrow_back</span>
                            Kembali
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="mb-8 bg-green-50 text-green-700 px-6 py-4 rounded-2xl text-sm font-medium flex items-center gap-3">
                            <span class="material-symbols-outlined">check_circle</span>
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Foto Profil --}}
                    <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="flex flex-col md:flex-row items-center gap-8 mb-16 p-8 bg-naomi-bg rounded-[2.5rem] border-2 border-dashed border-charcoal/5">
                            <div class="relative group">
                                <div class="w-32 h-32 rounded-[2rem] overflow-hidden border-4 border-naomi-white shadow-xl rotate-3 transition-transform group-hover:rotate-0">
                                    @if($customer->avatar)
                                        <img src="{{ asset('storage/' . $customer->avatar) }}" class="w-full h-full object-cover" alt="Foto Profil" id="previewImg">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&background=2D2A28&color=fff&bold=true&size=256"
                                             class="w-full h-full object-cover" alt="Foto Profil" id="previewImg">
                                    @endif
                                </div>
                            </div>
                            <div class="flex-1 text-center md:text-left">
                                <p class="font-black text-charcoal uppercase text-[10px] tracking-widest mb-2">Foto Profil</p>
                                <p class="text-xs text-charcoal/50 mb-6 font-medium">Unggah file JPG, PNG (Maksimal 2MB).</p>
                                <button type="button" onclick="document.getElementById('foto').click()"
                                        class="px-8 py-3 bg-charcoal text-naomi-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-primary transition-all shadow-lg">
                                    Ubah Foto
                                </button>
                                <input type="file" id="foto" name="avatar" class="hidden" accept="image/*"
                                       onchange="previewPhoto(this)">
                            </div>
                        </div>

                        {{-- Form Fields --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div class="space-y-3">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-charcoal/40 ml-2">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $customer->name) }}"
                                       class="w-full px-6 py-5 bg-naomi-bg border-2 border-transparent rounded-2xl focus:border-primary/30 focus:bg-white outline-none font-medium text-charcoal transition-all">
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="space-y-3">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-charcoal/40 ml-2">Nomor WhatsApp</label>
                                <input type="tel" name="phone" value="{{ old('phone', $customer->phone) }}"
                                       class="w-full px-6 py-5 bg-naomi-bg border-2 border-transparent rounded-2xl focus:border-primary/30 focus:bg-white outline-none font-medium text-charcoal transition-all">
                                @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="space-y-3">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-charcoal/40 ml-2">Alamat Email</label>
                                <input type="email" value="{{ auth()->user()->email }}" disabled
                                       class="w-full px-6 py-5 bg-naomi-bg/50 border-2 border-transparent rounded-2xl outline-none font-medium text-charcoal/40 cursor-not-allowed">
                                <p class="text-[10px] text-charcoal/30 ml-2">Email tidak dapat diubah</p>
                            </div>
                            <div class="space-y-3">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-charcoal/40 ml-2">Tanggal Lahir</label>
                                <input type="date" name="date_of_birth"
                                       value="{{ old('date_of_birth', $customer->date_of_birth?->format('Y-m-d')) }}"
                                       class="w-full px-6 py-5 bg-naomi-bg border-2 border-transparent rounded-2xl focus:border-primary/30 focus:bg-white outline-none font-medium text-charcoal transition-all">
                                @error('date_of_birth') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="space-y-3">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-charcoal/40 ml-2">Jenis Kelamin</label>
                                <select name="gender"
                                        class="w-full px-6 py-5 bg-naomi-bg border-2 border-transparent rounded-2xl focus:border-primary/30 focus:bg-white outline-none font-medium text-charcoal transition-all">
                                    <option value="">Pilih...</option>
                                    <option value="male" {{ old('gender', $customer->gender) === 'male' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="female" {{ old('gender', $customer->gender) === 'female' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="space-y-3 mt-10">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-charcoal/40 ml-2">Alamat Domisili</label>
                            <textarea rows="4" name="address"
                                      placeholder="Tambahkan alamat lengkap Anda di sini..."
                                      class="w-full px-6 py-5 bg-naomi-bg border-2 border-transparent rounded-[2rem] focus:border-primary/30 focus:bg-white outline-none font-medium text-charcoal transition-all resize-none">{{ old('address', $customer->address) }}</textarea>
                            @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex justify-end gap-4 pt-8 border-t border-naomi-bg mt-10">
                            <a href="{{ route('profil') }}"
                               class="px-10 py-5 border-2 border-charcoal/5 rounded-2xl text-[10px] font-black uppercase tracking-widest text-charcoal/40 hover:bg-naomi-bg transition-all">
                                Batal
                            </a>
                            <button type="submit"
                                    class="px-12 py-5 bg-primary text-naomi-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-primary/20 hover:bg-charcoal transition-all duration-500">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => document.getElementById('previewImg').src = e.target.result;
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
