<div class="max-w-4xl">
    <div class="bg-white rounded-2xl shadow-sm border border-naomi-muted/20 p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Bulan/Periode --}}
            <div>
                <label class="block text-xs font-bold text-naomi-muted uppercase tracking-widest mb-2">Bulan & Tahun</label>
                <input type="month" name="period"
                       value="{{ old('period', isset($maintenance)
                           ? $maintenance->period_year . '-' . str_pad($maintenance->period_month, 2, '0', STR_PAD_LEFT)
                           : now()->format('Y-m')) }}"
                       class="w-full bg-naomi-bg/20 border border-naomi-muted/20 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                @error('period') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Kategori --}}
            <div>
                <label class="block text-xs font-bold text-naomi-muted uppercase tracking-widest mb-2">Kategori</label>
                <select name="category"
                        class="w-full bg-naomi-bg/20 border border-naomi-muted/20 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                    @foreach(['listrik' => 'Listrik', 'air' => 'Air (PDAM)', 'wifi' => 'Internet/WiFi', 'kebersihan' => 'Kebersihan', 'lain-lain' => 'Lain-lain'] as $val => $label)
                    <option value="{{ $val }}" {{ old('category', $maintenance->category ?? '') === $val ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>
                @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Jumlah Biaya --}}
            <div>
                <label class="block text-xs font-bold text-naomi-muted uppercase tracking-widest mb-2">Jumlah Biaya (Rp)</label>
                <input type="number" name="amount" min="1"
                       value="{{ old('amount', $maintenance->amount ?? '') }}"
                       placeholder="Contoh: 500000"
                       class="w-full bg-naomi-bg/20 border border-naomi-muted/20 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                @error('amount') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tanggal Pembayaran --}}
            <div>
                <label class="block text-xs font-bold text-naomi-muted uppercase tracking-widest mb-2">Tanggal Bayar</label>
                <input type="date" name="payment_date"
                       value="{{ old('payment_date', isset($maintenance) ? $maintenance->payment_date->format('Y-m-d') : now()->format('Y-m-d')) }}"
                       class="w-full bg-naomi-bg/20 border border-naomi-muted/20 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                @error('payment_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Keterangan --}}
            <div class="md:col-span-2 border-t border-naomi-bg pt-4">
                <label class="block text-xs font-bold text-naomi-muted uppercase tracking-widest mb-2">Keterangan / Catatan</label>
                <textarea name="description" rows="3"
                          placeholder="Contoh: Pembayaran listrik bulan Maret (naik karena AC sering nyala)"
                          class="w-full bg-naomi-bg/20 border border-naomi-muted/20 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all resize-none">{{ old('description', $maintenance->description ?? '') }}</textarea>
            </div>
        </div>
    </div>

    <div class="flex justify-end gap-3 mt-8">
        <a href="{{ route('admin.maintenance.index') }}"
           class="px-8 py-3 rounded-xl text-sm font-bold text-naomi-muted border border-naomi-muted/20 hover:bg-naomi-surface/30 transition-all">
            Batal
        </a>
        <button type="submit"
                class="px-8 py-3 bg-primary text-white rounded-xl text-sm font-bold shadow-lg shadow-primary/20 hover:bg-charcoal transition-all flex items-center gap-2">
            <span class="material-symbols-outlined text-sm">payments</span>
            {{ isset($maintenance) ? 'Simpan Perubahan' : 'Simpan Biaya' }}
        </button>
    </div>
</div>
