<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Pelanggan Naomi Studio</title>
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
  .header { display: table; width: 100%; margin-bottom: 20px; }
  .header-left { display: table-cell; vertical-align: top; width: 55%; }
  .header-right { display: table-cell; vertical-align: top; text-align: right; }
  .brand { font-size: 20px; font-weight: 900; letter-spacing: -0.5px; }
  .brand-sub { font-size: 8px; text-transform: uppercase; letter-spacing: 3px; color: #A8A29E; margin-top: 2px; }
  .report-label { font-size: 18px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; }
  .report-period { font-size: 11px; font-weight: 700; color: #A8A29E; margin-top: 3px; }
  .report-date { font-size: 8px; color: #A8A29E; margin-top: 2px; }
  .divider { border: none; border-top: 1.5px solid #F0EDE8; margin: 0 0 18px; }
  .cards { display: table; width: 100%; margin-bottom: 18px; }
  .card { display: table-cell; width: 25%; padding: 14px 16px; border-radius: 8px; vertical-align: top; }
  .card-gap { display: table-cell; width: 10px; }
  .card-primary { background: #f8fafc; border: 1px solid #cbd5e1; }
  .card-secondary { background: #f0fdf4; border: 1px solid #86efac; }
  .card-muted { background: #f8fafc; border: 1px solid #e2e8f0; }
  .card-accent { background: #1A1918; color: #fff; }
  .card-label { font-size: 7px; text-transform: uppercase; letter-spacing: 2px; font-weight: 700; margin-bottom: 6px; }
  .card-value { font-size: 15px; font-weight: 900; }
  .card-sub { font-size: 8px; margin-top: 4px; color: #6b7280; }
  .section-title { font-size: 8px; text-transform: uppercase; letter-spacing: 2px; color: #A8A29E; font-weight: 700; margin-bottom: 8px; }
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
  .badge { display: inline-block; padding: 1px 6px; border-radius: 8px; font-size: 7px; font-weight: 700; text-transform: uppercase; }
  .badge-active { background: #d1fae5; color: #047857; }
  .badge-inactive { background: #fee2e2; color: #b91c1c; }
  .two-col { display: table; width: 100%; }
  .col-left { display: table-cell; width: 52%; vertical-align: top; padding-right: 12px; }
  .col-right { display: table-cell; width: 48%; vertical-align: top; }
  .footer { border-top: 1.5px solid #F0EDE8; padding-top: 12px; display: table; width: 100%; margin-top: 4px; }
  .footer-left { display: table-cell; vertical-align: bottom; }
  .footer-right { display: table-cell; text-align: right; vertical-align: bottom; }
  .footer-note { font-size: 7px; color: #A8A29E; line-height: 1.7; }
  .footer-brand { font-size: 11px; font-weight: 900; color: #1A1918; }
  .footer-sub { font-size: 7px; color: #A8A29E; }
  .no-data { text-align: center; padding: 18px; color: #A8A29E; font-size: 8px; }
</style>
</head>
<body>

<div class="accent-bar"></div>
<div class="page">

  <div class="header">
    <div class="header-left">
      <div class="brand">Naomi Studio</div>
      <div class="brand-sub">Customer Report &nbsp;·&nbsp; Admin Panel</div>
    </div>
    <div class="header-right">
      <div class="report-label">Laporan Pelanggan</div>
      <div class="report-period">Semua Periode</div>
      <div class="report-date">Diterbitkan {{ $generatedAt->format('d M Y, H:i') }}</div>
    </div>
  </div>

  <hr class="divider">

  <div class="cards">
    <div class="card card-primary">
      <div class="card-label">Total Pelanggan</div>
      <div class="card-value">{{ $stats['total_customers'] }}</div>
      <div class="card-sub">{{ $stats['active_customers'] }} Aktif • {{ $stats['inactive_customers'] }} Nonaktif</div>
    </div>
    <div class="card-gap"></div>
    <div class="card card-secondary">
      <div class="card-label">Booking Terkonfirmasi</div>
      <div class="card-value">{{ $stats['confirmed_bookings'] }}</div>
      <div class="card-sub">Hitungan booking confirmed / completed</div>
    </div>
    <div class="card-gap"></div>
    <div class="card card-muted">
      <div class="card-label">Pendapatan Terverifikasi</div>
      <div class="card-value">Rp{{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
      <div class="card-sub">Total pembayaran verified</div>
    </div>
    <div class="card-gap"></div>
    <div class="card card-accent">
      <div class="card-label">Pelanggan Aktif</div>
      <div class="card-value">{{ $stats['active_customers'] }}</div>
      <div class="card-sub">Aktif di sistem</div>
    </div>
  </div>

  <div class="section-title">Top 10 Pelanggan Terbanyak Booking</div>
  <table>
    <thead>
      <tr>
        <th style="width:5%">#</th>
        <th style="width:30%">Nama</th>
        <th style="width:20%">Email</th>
        <th class="right" style="width:15%">Booking</th>
        <th class="right" style="width:20%">Total Pengeluaran</th>
        <th class="right" style="width:10%">Status</th>
      </tr>
    </thead>
    <tbody>
      @forelse($topBookers as $index => $customer)
      <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $customer['name'] }}</td>
        <td>{{ $customer['email'] }}</td>
        <td class="right">{{ $customer['bookings_count'] }}</td>
        <td class="right">Rp{{ number_format($customer['total_spent'], 0, ',', '.') }}</td>
        <td class="right">
          <span class="badge {{ $customer['status'] === 'Aktif' ? 'badge-active' : 'badge-inactive' }}">{{ $customer['status'] }}</span>
        </td>
      </tr>
      @empty
      <tr><td colspan="6" class="no-data">Tidak ada data pelanggan</td></tr>
      @endforelse
    </tbody>
  </table>

  <div class="section-title">Top 10 Pelanggan Berdasarkan Pengeluaran</div>
  <table>
    <thead>
      <tr>
        <th style="width:5%">#</th>
        <th style="width:26%">Nama</th>
        <th style="width:22%">Email</th>
        <th class="right" style="width:14%">Booking</th>
        <th class="right" style="width:18%">Total Pengeluaran</th>
        <th class="right" style="width:15%">Status</th>
      </tr>
    </thead>
    <tbody>
      @forelse($topSpenders as $index => $customer)
      <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $customer['name'] }}</td>
        <td>{{ $customer['email'] }}</td>
        <td class="right">{{ $customer['bookings_count'] }}</td>
        <td class="right">Rp{{ number_format($customer['total_spent'], 0, ',', '.') }}</td>
        <td class="right">
          <span class="badge {{ $customer['status'] === 'Aktif' ? 'badge-active' : 'badge-inactive' }}">{{ $customer['status'] }}</span>
        </td>
      </tr>
      @empty
      <tr><td colspan="6" class="no-data">Tidak ada data pelanggan</td></tr>
      @endforelse
    </tbody>
  </table>

  <div class="two-col">
    <div class="col-left">
      <div class="section-title">Distribusi Status Pelanggan</div>
      <table>
        <thead>
          <tr>
            <th style="width:60%">Kategori</th>
            <th class="right" style="width:40%">Jumlah</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Aktif</td>
            <td class="right">{{ $statusDistribution['active'] }}</td>
          </tr>
          <tr>
            <td>Nonaktif</td>
            <td class="right">{{ $statusDistribution['inactive'] }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="col-right">
      <div class="section-title">10 Pelanggan Terbaru</div>
      <table>
        <thead>
          <tr>
            <th style="width:50%">Nama</th>
            <th class="right" style="width:25%">Booking</th>
            <th class="right" style="width:25%">Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse($recentCustomers as $customer)
          <tr>
            <td>{{ $customer['name'] }}</td>
            <td class="right">{{ $customer['bookings_count'] }}</td>
            <td class="right">
              <span class="badge {{ $customer['status'] === 'Aktif' ? 'badge-active' : 'badge-inactive' }}">{{ $customer['status'] }}</span>
            </td>
          </tr>
          @empty
          <tr><td colspan="3" class="no-data">Tidak ada pelanggan terbaru</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="footer">
    <div class="footer-left">
      <div class="footer-note">
        Laporan ini diterbitkan otomatis oleh sistem Naomi Studio.
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