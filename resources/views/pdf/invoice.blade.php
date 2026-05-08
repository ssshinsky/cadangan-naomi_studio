<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Invoice {{ $booking->booking_code }}</title>
<style>
  @page { margin: 0; size: A4; }
  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    font-family: 'DejaVu Sans', Arial, sans-serif;
    font-size: 11px;
    color: #1A1918;
    background: #fff;
    width: 210mm;
    min-height: 297mm;
  }

  /* ── TOP ACCENT BAR ── */
  .accent-bar {
    height: 6px;
    background: #1A1918;
    width: 100%;
  }

  .page {
    padding: 32px 40px 28px;
  }

  /* ── HEADER ── */
  .header {
    display: table;
    width: 100%;
    margin-bottom: 24px;
  }
  .header-left  { display: table-cell; vertical-align: top; width: 55%; }
  .header-right { display: table-cell; vertical-align: top; text-align: right; }

  .brand { font-size: 22px; font-weight: 900; letter-spacing: -0.5px; color: #1A1918; }
  .brand-sub { font-size: 9px; text-transform: uppercase; letter-spacing: 3px; color: #A8A29E; margin-top: 2px; }

  .invoice-label { font-size: 20px; font-weight: 900; text-transform: uppercase; letter-spacing: 3px; color: #1A1918; }
  .invoice-code  { font-size: 10px; color: #A8A29E; margin-top: 3px; font-family: 'DejaVu Sans Mono', monospace; }
  .invoice-date  { font-size: 9px; color: #A8A29E; margin-top: 2px; }

  .status-pill {
    display: inline-block;
    margin-top: 6px;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 8px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    border: 1px solid #86efac;
    background: #f0fdf4;
    color: #16a34a;
  }
  .status-pill.completed { border-color: #93c5fd; background: #eff6ff; color: #2563eb; }

  /* ── DIVIDER ── */
  .divider { border: none; border-top: 1.5px solid #F0EDE8; margin: 0 0 20px; }

  /* ── INFO ROW ── */
  .info-row { display: table; width: 100%; margin-bottom: 20px; }
  .info-cell {
    display: table-cell;
    width: 33.33%;
    padding: 14px 16px;
    background: #F5F3F0;
    border-radius: 8px;
    vertical-align: top;
  }
  .info-cell + .info-cell { margin-left: 10px; }
  .info-gap { display: table-cell; width: 10px; }

  .info-label { font-size: 8px; text-transform: uppercase; letter-spacing: 2px; color: #A8A29E; font-weight: 700; margin-bottom: 5px; }
  .info-value { font-size: 12px; font-weight: 700; color: #1A1918; line-height: 1.4; }
  .info-sub   { font-size: 9px; color: #A8A29E; margin-top: 2px; line-height: 1.4; }

  /* ── TABLE ── */
  .section-label { font-size: 8px; text-transform: uppercase; letter-spacing: 2px; color: #A8A29E; font-weight: 700; margin-bottom: 8px; }

  table.items { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
  table.items thead tr { background: #1A1918; }
  table.items thead th {
    padding: 9px 12px;
    text-align: left;
    font-size: 8px;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #fff;
    font-weight: 700;
  }
  table.items thead th.right { text-align: right; }
  table.items tbody tr { border-bottom: 1px solid #F0EDE8; }
  table.items tbody td { padding: 11px 12px; font-size: 10px; vertical-align: top; }
  table.items tbody td.right { text-align: right; font-weight: 700; }
  .item-name { font-weight: 700; font-size: 11px; }
  .item-sub  { font-size: 9px; color: #A8A29E; margin-top: 2px; }

  /* ── SUMMARY + PAYMENTS ── */
  .bottom-row { display: table; width: 100%; margin-bottom: 20px; }
  .bottom-left  { display: table-cell; width: 52%; vertical-align: top; padding-right: 16px; }
  .bottom-right { display: table-cell; width: 48%; vertical-align: top; }

  .summary-box { background: #F5F3F0; border-radius: 8px; padding: 14px 16px; }
  .sum-row { display: table; width: 100%; padding: 4px 0; font-size: 10px; }
  .sum-label { display: table-cell; color: #A8A29E; }
  .sum-value { display: table-cell; text-align: right; font-weight: 700; }
  .sum-row.total-row { border-top: 1.5px solid #E0DDD8; margin-top: 6px; padding-top: 8px; }
  .sum-row.total-row .sum-label { font-size: 11px; font-weight: 700; color: #1A1918; }
  .sum-row.total-row .sum-value { font-size: 13px; font-weight: 900; color: #1A1918; }
  .sum-row.paid-row .sum-value  { color: #16a34a; }
  .sum-row.due-row  .sum-value  { color: #d97706; }
  .sum-row.done-row .sum-value  { color: #16a34a; }

  .pay-title { font-size: 8px; text-transform: uppercase; letter-spacing: 2px; color: #A8A29E; font-weight: 700; margin-bottom: 8px; }
  .pay-item { display: table; width: 100%; padding: 7px 0; border-bottom: 1px solid #F0EDE8; font-size: 9px; }
  .pay-item:last-child { border-bottom: none; }
  .pay-left  { display: table-cell; vertical-align: middle; }
  .pay-right { display: table-cell; text-align: right; font-weight: 700; color: #16a34a; vertical-align: middle; }
  .badge {
    display: inline-block;
    padding: 2px 7px;
    border-radius: 10px;
    font-size: 7px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-right: 4px;
  }
  .badge-dp        { background: #fef3c7; color: #d97706; }
  .badge-full      { background: #f0fdf4; color: #16a34a; }
  .badge-pelunasan { background: #eff6ff; color: #2563eb; }
  .pay-meta { color: #A8A29E; font-size: 8px; }

  /* ── FOOTER ── */
  .footer { display: table; width: 100%; border-top: 1.5px solid #F0EDE8; padding-top: 14px; }
  .footer-left  { display: table-cell; vertical-align: bottom; }
  .footer-right { display: table-cell; text-align: right; vertical-align: bottom; }
  .footer-note  { font-size: 8px; color: #A8A29E; line-height: 1.7; }
  .footer-brand { font-size: 13px; font-weight: 900; color: #1A1918; }
  .footer-brand-sub { font-size: 8px; color: #A8A29E; margin-top: 1px; }
</style>
</head>
<body>

<div class="accent-bar"></div>

<div class="page">

  {{-- ── HEADER ── --}}
  <div class="header">
    <div class="header-left">
      <div class="brand">Naomi Studio</div>
      <div class="brand-sub">Premium Dance Space &nbsp;·&nbsp; Yogyakarta</div>
    </div>
    <div class="header-right">
      <div class="invoice-label">Invoice</div>
      <div class="invoice-code">{{ $booking->booking_code }}</div>
      <div class="invoice-date">Diterbitkan {{ now()->format('d M Y') }}</div>
      <div>
        <span class="status-pill {{ $booking->booking_status === 'completed' ? 'completed' : '' }}">
          {{ $booking->booking_status === 'completed' ? 'Selesai' : 'Dikonfirmasi' }}
        </span>
      </div>
    </div>
  </div>

  <hr class="divider">

  {{-- ── INFO ROW ── --}}
  <div class="info-row">
    <div class="info-cell">
      <div class="info-label">Tagihan Kepada</div>
      <div class="info-value">{{ $customer->name }}</div>
      <div class="info-sub">{{ $customer->user->email }}</div>
      @if($customer->phone)<div class="info-sub">{{ $customer->phone }}</div>@endif
    </div>
    <div class="info-gap"></div>
    <div class="info-cell">
      <div class="info-label">Detail Booking</div>
      <div class="info-value">{{ $booking->studio->name }}</div>
      <div class="info-sub">{{ $booking->date->format('d M Y') }}</div>
      <div class="info-sub">{{ substr($booking->start_time,0,5) }} – {{ substr($booking->end_time,0,5) }} WIB</div>
    </div>
    <div class="info-gap"></div>
    <div class="info-cell">
      <div class="info-label">Durasi & Peserta</div>
      <div class="info-value">{{ $booking->duration_hours }} Jam</div>
      @if($booking->participant_count)<div class="info-sub">{{ $booking->participant_count }} peserta</div>@endif
      @if($booking->studio->floor_type)<div class="info-sub">Lantai {{ $booking->studio->floor_type }}</div>@endif
    </div>
  </div>

  {{-- ── ITEMS TABLE ── --}}
  <div class="section-label">Rincian Biaya</div>
  <table class="items">
    <thead>
      <tr>
        <th style="width:50%">Deskripsi</th>
        <th class="right" style="width:16%">Durasi</th>
        <th class="right" style="width:17%">Harga/Jam</th>
        <th class="right" style="width:17%">Subtotal</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <div class="item-name">Sewa {{ $booking->studio->name }}</div>
          <div class="item-sub">{{ $booking->date->format('d M Y') }} &nbsp;·&nbsp; {{ substr($booking->start_time,0,5) }}–{{ substr($booking->end_time,0,5) }}</div>
        </td>
        <td class="right">{{ $booking->duration_hours }} jam</td>
        <td class="right">Rp{{ number_format($booking->total_price / max($booking->duration_hours,1), 0, ',', '.') }}</td>
        <td class="right">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</td>
      </tr>
    </tbody>
  </table>

  {{-- ── BOTTOM: SUMMARY + PAYMENTS ── --}}
  @php $verifiedPayments = $booking->payments->where('status','verified'); $totalPaid = $verifiedPayments->sum('amount'); @endphp
  <div class="bottom-row">

    {{-- Riwayat Pembayaran --}}
    <div class="bottom-left">
      <div class="pay-title">Riwayat Pembayaran</div>
      @forelse($verifiedPayments as $pay)
      <div class="pay-item">
        <div class="pay-left">
          <span class="badge badge-{{ $pay->payment_type }}">{{ strtoupper($pay->payment_type) }}</span>
          <span class="pay-meta">{{ $pay->paid_at->format('d M Y') }} &nbsp;·&nbsp; {{ str_replace('_',' ',strtoupper($pay->payment_method)) }}</span>
        </div>
        <div class="pay-right">Rp{{ number_format($pay->amount,0,',','.') }}</div>
      </div>
      @empty
      <div style="font-size:9px;color:#A8A29E;padding:8px 0">Belum ada pembayaran terverifikasi.</div>
      @endforelse
    </div>

    {{-- Ringkasan --}}
    <div class="bottom-right">
      <div class="summary-box">
        <div class="sum-row">
          <span class="sum-label">Total Tagihan</span>
          <span class="sum-value">Rp{{ number_format($booking->total_price,0,',','.') }}</span>
        </div>
        <div class="sum-row paid-row">
          <span class="sum-label">Total Dibayar</span>
          <span class="sum-value">- Rp{{ number_format($totalPaid,0,',','.') }}</span>
        </div>
        <div class="sum-row total-row {{ $booking->remaining_amount > 0 ? 'due-row' : 'done-row' }}">
          <span class="sum-label">{{ $booking->remaining_amount > 0 ? 'Sisa Tagihan' : 'Status' }}</span>
          <span class="sum-value">
            @if($booking->remaining_amount > 0)
              Rp{{ number_format($booking->remaining_amount,0,',','.') }}
            @else
              LUNAS 
            @endif
          </span>
        </div>
      </div>
    </div>

  </div>

  {{-- ── FOOTER ── --}}
  <div class="footer">
    <div class="footer-left">
      <div class="footer-note">
        Dokumen ini diterbitkan otomatis oleh sistem Naomi Studio.<br>
        Simpan sebagai bukti pembayaran yang sah. Pertanyaan? Hubungi kami via WhatsApp.
      </div>
    </div>
    <div class="footer-right">
      <div class="footer-brand">Naomi Studio</div>
      <div class="footer-brand-sub">Premium Dance Space &nbsp;·&nbsp; Yogyakarta</div>
    </div>
  </div>

</div>
</body>
</html>
