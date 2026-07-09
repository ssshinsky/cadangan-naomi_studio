@extends('layouts.app')

@section('title', 'Checkout - Naomi Studio')

@section('content')
<main class="bg-naomi-bg min-h-screen pb-20">
    <div class="max-w-7xl mx-auto px-6 py-12">

        <div class="mb-12">
            <a href="{{ route('booking.index') }}"
               class="inline-flex items-center gap-2 mb-6 px-4 py-2 bg-naomi-white border border-charcoal/10 hover:border-primary hover:text-primary text-charcoal/60 rounded-full text-[10px] font-black uppercase tracking-[0.2em] transition-all shadow-sm">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Kembali ke Booking
            </a>
            <h1 class="serif-title text-5xl md:text-6xl font-bold text-charcoal leading-[0.9] tracking-tighter">
                Selesaikan <span class="text-primary italic">Pembayaran</span>
            </h1>
            <p class="text-charcoal/80 mt-6 max-w-xl font-medium text-lg">Amankan jadwal Anda dengan menyelesaikan pembayaran di bawah ini.</p>
        </div>

        <form method="POST" action="{{ route('payment.store') }}" enctype="multipart/form-data" id="paymentForm">
        @csrf

        {{-- Hidden booking IDs --}}
        @foreach($bookings as $booking)
            <input type="hidden" name="booking_ids[]" value="{{ $booking->id }}">
        @endforeach
        <input type="hidden" name="payment_type" id="inputPaymentType" value="full">
        <input type="hidden" name="payment_method" id="inputPaymentMethod" value="transfer_bca">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            <div class="lg:col-span-8 space-y-10">

                {{-- Step 1: Opsi Pembayaran --}}
                <section class="bg-naomi-white rounded-[3rem] p-10 shadow-sm border border-charcoal/10">
                    <div class="flex items-center gap-5 mb-10">
                        <div class="w-12 h-12 bg-primary text-naomi-white rounded-2xl flex items-center justify-center font-black text-xl shadow-lg shadow-primary/20">1</div>
                        <h3 class="serif-title text-3xl font-bold text-charcoal">Pilih Opsi Pembayaran</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div onclick="selectPaymentOption(this, 'full')" id="cardLunas"
                             class="payment-option cursor-pointer rounded-[2.5rem] border-2 border-primary bg-primary/5 p-8 transition-all active shadow-xl shadow-primary/5">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-black text-xl text-charcoal">Bayar Lunas</p>
                                    <p class="text-4xl font-black text-primary mt-4 tracking-tighter">Rp{{ number_format($totalFull, 0, ',', '.') }}</p>
                                    <p class="text-sm text-charcoal/70 mt-6 font-medium">Akses penuh dan jadwal langsung terverifikasi.</p>
                                </div>
                                <span class="material-symbols-outlined text-4xl text-primary font-black">check_circle</span>
                            </div>
                        </div>

                        <div onclick="selectPaymentOption(this, 'dp')" id="cardDP"
                             class="payment-option cursor-pointer rounded-[2.5rem] border-2 border-charcoal/10 p-8 hover:border-primary/30 transition-all">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-black text-xl text-charcoal/60">DP</p>
                                    <p class="text-4xl font-black text-charcoal/40 mt-4 tracking-tighter">Rp{{ number_format($totalDP, 0, ',', '.') }}</p>
                                    <p class="text-sm text-charcoal/50 mt-6 font-medium">Sisa pembayaran dilunasi saat kedatangan.</p>
                                </div>
                                <span class="material-symbols-outlined text-4xl text-charcoal/20 font-black">radio_button_unchecked</span>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Step 2: Metode Transfer --}}
                <section class="bg-naomi-white rounded-[3rem] p-10 shadow-sm border border-charcoal/10">
                    <div class="flex items-center gap-5 mb-10">
                        <div class="w-12 h-12 bg-primary text-naomi-white rounded-2xl flex items-center justify-center font-black text-xl shadow-lg shadow-primary/20">2</div>
                        <h3 class="serif-title text-3xl font-bold text-charcoal">Metode Transfer</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4" id="paymentMethods">
                        <div onclick="selectTransferMethod(0)" id="methodBCA"
                             class="transfer-method cursor-pointer flex flex-col items-center justify-center p-8 rounded-[2rem] border-2 border-primary bg-primary/5 gap-3 active shadow-lg shadow-primary/5">
                            <div class="h-10 w-20 bg-naomi-white rounded-xl flex items-center justify-center text-blue-800 font-black text-sm border border-charcoal/5">BCA</div>
                            <span class="font-black text-charcoal uppercase text-[10px] tracking-widest">Transfer BCA</span>
                        </div>

                        <div onclick="selectTransferMethod(1)" id="methodBNI"
                             class="transfer-method cursor-pointer flex flex-col items-center justify-center p-8 rounded-[2rem] border-2 border-charcoal/10 hover:border-primary transition-all gap-3">
                            <div class="h-10 w-20 bg-naomi-white rounded-xl flex items-center justify-center text-orange-600 font-black text-sm border border-charcoal/5">BNI</div>
                            <span class="font-black text-charcoal/60 uppercase text-[10px] tracking-widest">Transfer BNI</span>
                        </div>

                        <div onclick="selectTransferMethod(2)" id="methodQRIS"
                             class="transfer-method cursor-pointer flex flex-col items-center justify-center p-8 rounded-[2rem] border-2 border-charcoal/10 hover:border-primary transition-all gap-3">
                            <span class="material-symbols-outlined text-5xl text-primary font-black">qr_code_2</span>
                            <span class="font-black text-charcoal/60 uppercase text-[10px] tracking-widest">QRIS</span>
                        </div>
                    </div>

                    <div id="transferDetail" class="mt-10">
                        <div id="bankDetail" class="bg-naomi-bg rounded-[2.5rem] p-10 border-2 border-dashed border-primary/30">
                            <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-center md:text-left">
                                <div>
                                    <p class="text-[10px] uppercase font-black text-charcoal/60 tracking-[0.2em] mb-2">Nomor Rekening Tujuan</p>
                                    <p id="norekDisplay" class="text-4xl font-black text-charcoal tracking-widest">6975716558</p>
                                    <p id="bankName" class="text-sm text-primary mt-2 font-black uppercase tracking-widest">a.n Cornelia Rosalin Naomi (BCA)</p>
                                </div>
                                <div class="flex flex-col items-center gap-3">
                                    <button type="button" onclick="copyRekening()"
                                            class="flex items-center gap-3 px-8 py-4 bg-naomi-white border-2 border-charcoal/10 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-primary hover:text-naomi-white transition-all shadow-sm">
                                        <span class="material-symbols-outlined text-lg" id="copyIcon">content_copy</span>
                                        <span id="copyText">Salin</span>
                                    </button>
                                    <span id="copySuccess" class="hidden text-green-600 text-[10px] font-black uppercase tracking-widest flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">check_circle</span>
                                        Berhasil disalin!
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div id="qrisDetail" class="hidden bg-naomi-bg rounded-[2.5rem] p-12 text-center border-2 border-dashed border-primary/30">
                            <p class="text-[10px] uppercase font-black text-charcoal/60 tracking-widest mb-6">Scan QRIS via Mobile Banking / E-Wallet</p>
                            <div class="mx-auto w-56 bg-naomi-white p-4 rounded-[2rem] shadow-xl border border-charcoal/5">
                                <img src="{{ asset('storage/aset aku/qris.jpeg') }}" alt="QRIS Naomi Studio" class="w-full h-auto rounded-xl object-contain">
                            </div>
                            <p class="text-xs text-charcoal/50 mt-4 font-medium">Naomi Studio</p>
                        </div>
                    </div>
                </section>

                {{-- Step 3: Upload Bukti --}}
                <section class="bg-naomi-white rounded-[3rem] p-10 shadow-sm border border-charcoal/10">
                    <div class="flex items-center gap-5 mb-10">
                        <div class="w-12 h-12 bg-primary text-naomi-white rounded-2xl flex items-center justify-center font-black text-xl shadow-lg shadow-primary/20">3</div>
                        <h3 class="serif-title text-3xl font-bold text-charcoal">Unggah Bukti</h3>
                    </div>

                    <div onclick="document.getElementById('bukti').click()"
                         class="group border-2 border-dashed border-charcoal/10 hover:border-primary/50 rounded-[2.5rem] p-10 text-center cursor-pointer transition-all bg-naomi-bg/50" id="uploadArea">
                        <div id="uploadPlaceholder">
                            <div class="w-20 h-20 bg-naomi-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-4xl text-charcoal/30 group-hover:text-primary transition-colors">cloud_upload</span>
                            </div>
                            <p id="uploadText" class="font-black text-charcoal uppercase text-xs tracking-widest">Klik untuk upload bukti pembayaran</p>
                            <p class="text-[10px] text-charcoal/40 mt-3 font-bold">JPG, PNG, atau PDF (Maks. 5MB)</p>
                        </div>
                        {{-- Preview foto --}}
                        <div id="uploadPreview" class="hidden">
                            <img id="previewImg" src="" alt="Preview" class="max-h-64 mx-auto rounded-2xl shadow-lg mb-4 object-contain">
                            <p id="uploadFileName" class="font-black text-primary text-xs uppercase tracking-widest"></p>
                            <p class="text-[10px] text-charcoal/40 mt-2">Klik untuk ganti foto</p>
                        </div>
                    </div>
                    <input type="file" id="bukti" name="proof_image" class="hidden" accept="image/*"
                           onchange="previewUpload(this)">
                </section>
            </div>

            {{-- Ringkasan --}}
            <div class="lg:col-span-4">
                <div class="bg-naomi-white rounded-[3rem] shadow-sm border border-charcoal/10 overflow-hidden sticky top-8">
                    <div class="bg-charcoal px-10 py-8 text-naomi-white">
                        <h3 class="serif-title font-bold text-2xl">Ringkasan Pesanan</h3>
                    </div>

                    <div class="p-10">
                        {{-- Daftar booking --}}
                        <div class="space-y-4 mb-8">
                            @foreach($bookings as $booking)
                            <div class="bg-naomi-bg rounded-2xl p-4">
                                <p class="font-black text-charcoal text-sm">{{ $booking->studio->name }}</p>
                                <p class="text-[10px] text-charcoal/50 mt-1">
                                    {{ $booking->date->format('d M Y') }} • {{ substr($booking->start_time,0,5) }}–{{ substr($booking->end_time,0,5) }}
                                </p>
                                <p class="text-[10px] text-primary font-black mt-1">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</p>
                            </div>
                            @endforeach
                        </div>

                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black uppercase text-charcoal/50 tracking-widest">Total Harga</span>
                                <span class="font-black text-charcoal">Rp{{ number_format($totalFull, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black uppercase text-charcoal/50 tracking-widest">DP</span>
                                <span id="dpAmountDisplay" class="font-black text-charcoal">Rp0</span>
                            </div>
                        </div>

                        <div class="border-t-2 border-charcoal/5 pt-8 mb-10">
                            <div class="flex justify-between items-end">
                                <div>
                                    <p class="text-[10px] font-black uppercase text-charcoal/50 tracking-widest">Yang Harus Dibayar</p>
                                    <p id="totalTagihan" class="text-4xl font-black text-primary tracking-tighter mt-1">
                                        Rp{{ number_format($totalFull, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <button type="button" onclick="showConfirmModal()"
                                class="w-full bg-primary text-naomi-white py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-primary/20 hover:bg-charcoal transition-all duration-500">
                            Konfirmasi Pembayaran
                        </button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</main>

{{-- Toast Notification --}}
<div id="toastNotif" class="hidden fixed top-6 right-6 z-[100] flex items-center gap-4 bg-red-600 text-white px-6 py-4 rounded-2xl shadow-2xl transition-all duration-300">
    <span class="material-symbols-outlined text-xl" id="toastIcon">error</span>
    <span id="toastMessage" class="font-bold text-sm"></span>
    <button onclick="document.getElementById('toastNotif').classList.add('hidden')" class="ml-2 opacity-70 hover:opacity-100">
        <span class="material-symbols-outlined text-lg">close</span>
    </button>
</div>

{{-- Modal Konfirmasi --}}
<div id="confirmModal" class="hidden fixed inset-0 bg-charcoal/70 backdrop-blur-md flex items-center justify-center z-50 p-6">
    <div class="bg-naomi-white rounded-[3rem] p-12 max-w-sm w-full text-center shadow-2xl border border-charcoal/10">
        <div class="w-24 h-24 bg-primary/10 text-primary rounded-full flex items-center justify-center mx-auto mb-8">
            <span class="material-symbols-outlined text-5xl font-black">verified</span>
        </div>
        <h3 class="serif-title text-3xl font-bold text-charcoal">Konfirmasi?</h3>
        <p id="modalAmount" class="text-charcoal/80 mt-4 mb-10 font-bold">
            Lanjutkan proses pembayaran sebesar <span id="modalAmountValue" class="text-primary font-black"></span>?
        </p>
        <div class="flex gap-4">
            <button type="button" onclick="hideConfirmModal()" class="flex-1 py-4 border-2 border-charcoal/10 rounded-2xl font-black text-xs uppercase tracking-widest text-charcoal/60 hover:bg-naomi-bg transition-colors">Batal</button>
            <button type="button" id="submitPayBtn" onclick="submitPayment()" class="flex-1 py-4 bg-primary text-naomi-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-primary/20 flex items-center justify-center gap-2">
                <span id="submitPayText">Ya, Bayar</span>
                <span id="submitPaySpinner" class="hidden material-symbols-outlined text-sm animate-spin">progress_activity</span>
            </button>
        </div>
    </div>
</div>

<script>
const totalFull = {{ $totalFull }};
const totalDP   = {{ $totalDP }};
let currentPaymentType = 'full';

const bankAccounts = {
    transfer_bca: { norek: '6975716558', name: 'a.n Cornelia Rosalin Naomi (BCA)' },
    transfer_bni: { norek: '0295134957', name: 'a.n Cornelia Rosalin Naomi (BNI)' },
};

function selectPaymentOption(card, type) {
    currentPaymentType = type;
    document.getElementById('inputPaymentType').value = type;

    document.querySelectorAll('.payment-option').forEach(c => {
        c.classList.remove('border-primary', 'bg-primary/5', 'active', 'shadow-xl', 'shadow-primary/5');
        c.classList.add('border-charcoal/10');
        c.querySelector('p:first-child').classList.replace('text-charcoal', 'text-charcoal/60');
        c.querySelector('p:nth-child(2)').classList.replace('text-primary', 'text-charcoal/40');
        c.querySelector('p:last-child').classList.replace('text-charcoal/70', 'text-charcoal/50');
        const icon = c.querySelector('.material-symbols-outlined');
        icon.textContent = 'radio_button_unchecked';
        icon.classList.replace('text-primary', 'text-charcoal/20');
    });

    card.classList.add('border-primary', 'bg-primary/5', 'active', 'shadow-xl', 'shadow-primary/5');
    card.classList.remove('border-charcoal/10');
    card.querySelector('p:first-child').classList.replace('text-charcoal/60', 'text-charcoal');
    card.querySelector('p:nth-child(2)').classList.replace('text-charcoal/40', 'text-primary');
    card.querySelector('p:last-child').classList.replace('text-charcoal/50', 'text-charcoal/70');
    const icon = card.querySelector('.material-symbols-outlined');
    icon.textContent = 'check_circle';
    icon.classList.replace('text-charcoal/20', 'text-primary');

    const amount = type === 'full' ? totalFull : totalDP;
    document.getElementById('totalTagihan').textContent = 'Rp' + amount.toLocaleString('id-ID');    document.getElementById('dpAmountDisplay').textContent = type === 'full'
        ? 'Rp0'
        : 'Rp' + totalDP.toLocaleString('id-ID');}

function selectTransferMethod(method) {
    document.querySelectorAll('.transfer-method').forEach(m => {
        m.classList.remove('active', 'border-primary', 'bg-primary/5', 'shadow-lg', 'shadow-primary/5');
        m.classList.add('border-charcoal/10');
        const span = m.querySelector('span:last-child');
        if (span) span.classList.replace('text-charcoal', 'text-charcoal/60');
    });

    const ids = ['methodBCA', 'methodBNI', 'methodQRIS'];
    const methodValues = ['transfer_bca', 'transfer_bni', 'qris'];
    const selected = document.getElementById(ids[method]);
    selected.classList.add('active', 'border-primary', 'bg-primary/5', 'shadow-lg', 'shadow-primary/5');
    selected.classList.remove('border-charcoal/10');
    const span = selected.querySelector('span:last-child');
    if (span) span.classList.replace('text-charcoal/60', 'text-charcoal');

    document.getElementById('inputPaymentMethod').value = methodValues[method];

    if (method === 2) {
        document.getElementById('bankDetail').classList.add('hidden');
        document.getElementById('qrisDetail').classList.remove('hidden');
    } else {
        document.getElementById('bankDetail').classList.remove('hidden');
        document.getElementById('qrisDetail').classList.add('hidden');
        const bank = bankAccounts[methodValues[method]];
        document.getElementById('norekDisplay').textContent = bank.norek;
        document.getElementById('bankName').textContent = bank.name;
    }
}

function copyRekening() {
    const norek = document.getElementById('norekDisplay').textContent.replace(/\s/g, '');
    navigator.clipboard.writeText(norek).then(() => {
        document.getElementById('copyText').textContent = 'Tersalin!';
        document.getElementById('copyIcon').textContent = 'check_circle';
        document.getElementById('copySuccess').classList.remove('hidden');
        document.getElementById('copySuccess').classList.add('flex');
        setTimeout(() => {
            document.getElementById('copyText').textContent = 'Salin';
            document.getElementById('copyIcon').textContent = 'content_copy';
            document.getElementById('copySuccess').classList.add('hidden');
            document.getElementById('copySuccess').classList.remove('flex');
        }, 2000);
    });
}

function previewUpload(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('uploadPlaceholder').classList.add('hidden');
            document.getElementById('uploadPreview').classList.remove('hidden');
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('uploadFileName').textContent = file.name;
        };
        reader.readAsDataURL(file);
    }
}

function showConfirmModal() {
    if (!document.getElementById('bukti').files.length) {
        showToast('Harap upload bukti pembayaran terlebih dahulu.', 'error');
        return;
    }
    const amount = currentPaymentType === 'full' ? totalFull : totalDP;
    document.getElementById('modalAmountValue').textContent = 'Rp' + amount.toLocaleString('id-ID');
    document.getElementById('confirmModal').classList.remove('hidden');
    document.getElementById('confirmModal').classList.add('flex');
}

function showToast(message, type = 'error') {
    const toast = document.getElementById('toastNotif');
    const toastMsg = document.getElementById('toastMessage');
    const toastIcon = document.getElementById('toastIcon');

    toastMsg.textContent = message;
    if (type === 'error') {
        toast.className = 'fixed top-6 right-6 z-[100] flex items-center gap-4 bg-red-600 text-white px-6 py-4 rounded-2xl shadow-2xl transition-all duration-300';
        toastIcon.textContent = 'error';
    } else {
        toast.className = 'fixed top-6 right-6 z-[100] flex items-center gap-4 bg-green-600 text-white px-6 py-4 rounded-2xl shadow-2xl transition-all duration-300';
        toastIcon.textContent = 'check_circle';
    }
    toast.classList.remove('hidden');
    setTimeout(() => toast.classList.add('hidden'), 3000);
}

function hideConfirmModal() {
    document.getElementById('confirmModal').classList.add('hidden');
    document.getElementById('confirmModal').classList.remove('flex');
}

let _submitting = false;
function submitPayment() {
    if (_submitting) return;
    _submitting = true;
    const btn = document.getElementById('submitPayBtn');
    btn.disabled = true;
    btn.classList.add('opacity-70', 'cursor-not-allowed');
    document.getElementById('submitPayText').textContent = 'Memproses...';
    document.getElementById('submitPaySpinner').classList.remove('hidden');
    document.getElementById('paymentForm').submit();
}
</script>
@endsection
