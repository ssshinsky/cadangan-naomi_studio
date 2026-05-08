<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Keuangan {{ date('F Y', mktime(0,0,0,$month,1,$year)) }}</title>
<style>
  @page { margin: 0; size: A4; }
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body {
    font-family: 'DejaVu Sans', Arial, sans-serif;
    font-size: 10px;
    color: #1A1918;
    background: #fff;
    width: 210mm;
    min-height: 297mm;
  }

  .accent-bar { height: 6px; background: #1A1918; width: 100%; }
  .page { padding: 30px 40px 28px; }

  /* HEADER */
  .header { display: table; width: 100%; margin-bottom: 20px; }
  .header-left  { display: table-cell; vertical-align: top; width: 55%; }
  .header-right { display: table-cell; vertical-align: top; text-align: right; }
  .brand     { font-size: 20px; font-weight: 900; letter-spacing: -0.5px; }
  .brand-sub { font-size: 8px; text-transform: uppercase; letter-spacing: 3px; color: #A8A29E; margin-top: 2px; }
  .report-label { font-size: 18px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; }
  .report-period { font-size: 11px; font-weight: 700; color: #A8A29E; margin-top: 3px; }
  .report-date   { font-size: 8px; color: #A8A29E; margin-top: 2px; }

  .divider { border: none; border-top: 1.5px solid #F0EDE8; margin: 0 0 18px; }

  /* SUMMARY CARDS */
  .cards { display: table; width: 100%; margin-bottom: 18px; }
  .card { display: table-cell; width: 33.33%; padding: 14px 16px; border-radius: 8px; vertical-align: top; }
  .card-gap { display: table-cell; width: 10px; }
  .card-income  { background: #f0fdf4; border: 1px solid #86efac; }
  .card-expense { background: #fef2f2; border: 1px solid #fca5a5; }
  .card-profit  { background: #1A1918; }
  .card-label { font-size: 7px; text-transform: uppercase; letter-spacing: 2px; font-weight: 700; margin-bottom: 6px; }
  .card-income  .card-label { color: #16a34a; }
  .card-expense .card-label { color: #dc2626; }
  .card-profit  .card-label { color: rgba(255,255,255,0.6); }
  .card-value { font-size: 15px; font-weight: 900; }
  .card-income  .card-value { color: #15803d; }
  .card-expense .card-value { color: #b91c1c; }
  .card-profit  .card-value { color: #fff; }
  .card-sub { font-size: 8px; margin-top: 3px; }
  .card-income  .card-sub { color: #16a34a; }
  .card-expense .card-sub { color: #dc2626; }
  .card-profit  .card-sub { color: rgba(255,255,255,0.5); }

  /* SECTION TITLE */
  .section-title { font-size: 8px; text-transform: uppercase; letter-spacing: 2px; color: #A8A29E; font-weight: 700; margin-bottom: 8px; }

  /* TABLES */
  table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
  thead tr { background: #1A1918; }
  thead th { padding: 8px 10px; text-align: left; font-size: 7px; text-transform: uppercase; letter-spacing: 1px; color: #fff; font-weight: 700; }
  thead th.right { text-align: right; }
  tbody tr { border-bottom: 1px solid #F0EDE8; }
  tbody tr:last-child { border-bottom: none; }
  tbody td { padding: 8px 10px; font-size: 9px; vertical-align: top; }
  tbody td.right { text-align: right; font-weight: 700; }
  tfoot tr { background: #F5F3F0; }
  tfoot td { padding: 8px 10px; font-size: 9px; font-weight: 700; }
  tfoot td.right { text-align: right; }

  .badge {
    display: inline-block; padding: 1px 6px; border-radius: 8px;
    font-size: 7px; font-weight: 700; text-transform: uppercase;
  }
  .badge-dp        { background: #fef3c7; color: #d97706; }
  .badge-full      { background: #f0fdf4; color: #16a34a; }
  .badge-pelunasan { background: #eff6ff; color: #2563eb; }

  .cat-listrik    { background: #dbeafe; color: #1d4ed8; }
  .cat-air        { background: #cffafe; color: #0e7490; }
  .cat-wifi       { background: #ede9fe; color: #6d28d9; }
  .cat-kebersihan { background: #dcfce7; color: #15803d; }
  .cat-lain       { background: #f3e8ff; color: #7e22ce; }

  /* TWO COLUMN LAYOUT */
  .two-col { display: table; width: 100%; }
  .col-left  { display: table-cell; width: 52%; vertical-align: top; padding-right: 12px; }
  .col-right { display: table-cell; width: 48%; vertical-align: top; }

  /* FOOTER */
  .footer { border-top: 1.5px solid #F0EDE8; padding-top: 12px; display: table; width: 100%; margin-top: 4px; }
  .footer-left  { display: table-cell; vertical-align: bottom; }
  .footer-right { display: table-cell; text-align: right; vertical-align: bottom; }
  .footer-note  { font-size: 7px; color: #A8A29E; line-height: 1.7; }
  .footer-brand { font-size: 11px; font-weight: 900; color: #1A1918; }
  .footer-sub   { font-size: 7px; color: #A8A29E; }
</style>
</head>
<body>

<div class="accent-bar"></div>
<div class="page">

  {{-- HEADER --}}
  <div class="header">
    <div class="header-left">
      <div class="brand">Naomi Studio</div>
      <div class="brand-sub">Premium Dance Space &nbsp;·&nbsp; Yogyakarta</div>
    </div>
    <div class="header-right">
      <div class="report-label">Laporan Keuangan</div>
      <div class="report-period">{{ date('F Y', mktime(0,0,0,$month,1,$year)) }}</div>
      <div class="report-date">Diterbitkan {{ now()->format('d M Y, H:i') }}</div>
    </div>
  </div>

  <hr class="divider">

  {{-- SUMMARY CARDS --}}
  <div class="cards">
    <div class="card card-income">
      <div class="card-label">Total Pemasukan</div>
      <div class="card-value">Rp{{ number_format($totalIncome, 0, ',', '.') }}</div>
      <div class="card-sub">{{ $payments->count() }} transaksi terverifikasi</div>
    </div>
    <div class="card-gap"></div>
    <div class="card card-expense">
      <div class="card-label">Total Pengeluaran</div>
      <div class="card-value">Rp{{ number_format($totalExpense, 0, ',', '.') }}</div>
      <div class="card-sub">{{ $costs->count() }} item operasional</div>
    </div>
    <div class="card-gap"></div>
    <div class="card card-profit">
      <div class="card-label">Laba Bersih</div>
      <div class="card-value">Rp{{ number_format($netProfit, 0, ',', '.') }}</div>
      <div class="card-sub">Profit margin {{ $margin }}%</div>
    </div>
  </div>

  {{-- GRAFIK CSS BAR CHART --}}
  @php
    $maxVal = max(array_merge($chartIncome, $chartExpense, [1]));
    $barMaxH = 60; // px, tinggi bar maksimum
  @endphp
  <div class="section-title" style="margin-bottom:6px">Tren 6 Bulan Terakhir</div>
  <div style="background:#F5F3F0;border-radius:8px;padding:12px 16px;margin-bottom:14px;">
    <div style="display:table;width:100%;margin-bottom:10px;">
      <div style="display:table-cell;font-size:8px;font-weight:700;color:#1A1918;">Pemasukan vs Pengeluaran</div>
      <div style="display:table-cell;text-align:right;font-size:7px;color:#A8A29E;">
        <span style="display:inline-block;width:8px;height:8px;background:#22c55e;margin-right:3px;vertical-align:middle;"></span>Pemasukan &nbsp;&nbsp;
        <span style="display:inline-block;width:8px;height:8px;background:#ef4444;margin-right:3px;vertical-align:middle;"></span>Pengeluaran
      </div>
    </div>
    <table style="width:100%;border-collapse:collapse;margin-bottom:0;">
      <tbody>
        {{-- Bar rows --}}
        <tr style="vertical-align:bottom;">
          @foreach($chartLabels as $i => $label)
          @php
            $incPct = $maxVal > 0 ? round(($chartIncome[$i] / $maxVal) * $barMaxH) : 0;
            $expPct = $maxVal > 0 ? round(($chartExpense[$i] / $maxVal) * $barMaxH) : 0;
          @endphp
          <td style="text-align:center;padding:0 4px;vertical-align:bottom;width:{{ round(100/count($chartLabels)) }}%;">
            <table style="width:100%;border-collapse:collapse;">
              <tbody>
                <tr style="vertical-align:bottom;">
                  <td style="width:48%;text-align:center;vertical-align:bottom;padding:0 1px;">
                    <div style="background:#22c55e;width:100%;height:{{ max($incPct,2) }}px;border-radius:2px 2px 0 0;"></div>
                  </td>
                  <td style="width:48%;text-align:center;vertical-align:bottom;padding:0 1px;">
                    <div style="background:#ef4444;width:100%;height:{{ max($expPct,2) }}px;border-radius:2px 2px 0 0;opacity:0.75;"></div>
                  </td>
                </tr>
              </tbody>
            </table>
            <div style="border-top:1px solid #E0DDD8;padding-top:4px;font-size:7px;color:#A8A29E;font-weight:700;">{{ $label }}</div>
          </td>
          @endforeach
        </tr>
      </tbody>
    </table>
  </div>

  {{-- TWO COLUMN: PEMASUKAN + PENGELUARAN --}}
  <div class="two-col">

    {{-- PEMASUKAN --}}
    <div class="col-left">
      <div class="section-title">Rincian Pemasukan</div>
      <table>
        <thead>
          <tr>
            <th style="width:38%">Pelanggan</th>
            <th style="width:22%">Studio</th>
            <th style="width:16%">Tipe</th>
            <th class="right" style="width:24%">Nominal</th>
          </tr>
        </thead>
        <tbody>
          @forelse($payments as $pay)
          <tr>
            <td>
              <div style="font-weight:700">{{ $pay->booking->customer->name }}</div>
              <div style="color:#A8A29E;font-size:8px">{{ $pay->paid_at->format('d M') }}</div>
            </td>
            <td style="color:#A8A29E;font-size:8px">{{ $pay->booking->studio->name }}</td>
            <td><span class="badge badge-{{ $pay->payment_type }}">{{ strtoupper($pay->payment_type) }}</span></td>
            <td class="right" style="color:#15803d">Rp{{ number_format($pay->amount,0,',','.') }}</td>
          </tr>
          @empty
          <tr><td colspan="4" style="text-align:center;color:#A8A29E;padding:12px">Tidak ada pemasukan</td></tr>
          @endforelse
        </tbody>
        <tfoot>
          <tr>
            <td colspan="3" style="font-weight:700">Total Pemasukan</td>
            <td class="right" style="color:#15803d">Rp{{ number_format($totalIncome,0,',','.') }}</td>
          </tr>
        </tfoot>
      </table>
    </div>

    {{-- PENGELUARAN --}}
    <div class="col-right">
      <div class="section-title">Rincian Pengeluaran</div>
      <table>
        <thead>
          <tr>
            <th style="width:30%">Tanggal</th>
            <th style="width:28%">Kategori</th>
            <th class="right" style="width:42%">Nominal</th>
          </tr>
        </thead>
        <tbody>
          @forelse($costs as $cost)
          @php
            $catClass = ['listrik'=>'cat-listrik','air'=>'cat-air','wifi'=>'cat-wifi','kebersihan'=>'cat-kebersihan','lain-lain'=>'cat-lain'][$cost->category] ?? 'cat-lain';
          @endphp
          <tr>
            <td>
              <div style="font-weight:700">{{ $cost->payment_date->format('d M') }}</div>
              <div style="color:#A8A29E;font-size:8px">{{ $cost->cost_code }}</div>
            </td>
            <td><span class="badge {{ $catClass }}">{{ $cost->category }}</span></td>
            <td class="right" style="color:#b91c1c">Rp{{ number_format($cost->amount,0,',','.') }}</td>
          </tr>
          @empty
          <tr><td colspan="3" style="text-align:center;color:#A8A29E;padding:12px">Tidak ada pengeluaran</td></tr>
          @endforelse
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2" style="font-weight:700">Total Pengeluaran</td>
            <td class="right" style="color:#b91c1c">Rp{{ number_format($totalExpense,0,',','.') }}</td>
          </tr>
        </tfoot>
      </table>
    </div>

  </div>

  {{-- FOOTER --}}
  <div class="footer">
    <div class="footer-left">
      <div class="footer-note">
        Laporan ini diterbitkan otomatis oleh sistem Naomi Studio.<br>
        Data berdasarkan transaksi terverifikasi dan biaya operasional periode {{ date('F Y', mktime(0,0,0,$month,1,$year)) }}.
      </div>
    </div>
    <div class="footer-right">
      <div class="footer-brand">Naomi Studio</div>
      <div class="footer-sub">Premium Dance Space &nbsp;·&nbsp; Yogyakarta</div>
    </div>
  </div>

</div>
</body>
</html>
