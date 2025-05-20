<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Struk Pengiriman</title>
  <style>
    body {
      font-family: 'Courier New', Courier, monospace;
      font-size: 11px;
      max-width: 350px;
      margin: auto;
      padding: 8px;
    }

    .center {
      text-align: center;
      margin: 20px 0;
    }

    .line {
      border-top: 1px dashed #000;
      margin: 6px 0;
    }

    .bold {
      font-weight: bold;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 4px;
    }

    td {
      padding: 2px 0;
      vertical-align: top;
    }

    .text-right {
      text-align: right;
    }

    table td:first-child {
      width: 0px;
    }

    table td:nth-child(2) {
      width: 10px;
    }

		table td:nth-child(3) {
			width: 300px;
		}

    .footer {
      margin-top: 10px;
      text-align: center;
      font-style: italic;
    }
  </style>
</head>

<body>

  <!-- Logo dan Judul -->
  <div class="center">
    <img src="{{ public_path('assets/img/logo-name.svg') }}" alt="Logo" width="120">
  </div>

  <div class="line"></div>

  <!-- Info Utama -->
  <table>
    <tr>
      <td>Tanggal</td>
      <td>:</td>
      <td>{{ now()->format('d/m/Y H:i') }}</td>
    </tr>
    <tr>
      <td>Nomor Resi</td>
      <td>:</td>
      <td><strong>{{ $barang->nomor_resi }}</strong></td>
    </tr>
  </table>

  <div class="line"></div>

  <!-- Informasi Barang -->
  <div class="bold">INFORMASI BARANG</div>
  <table>
    <tr>
      <td>Nama</td>
      <td>:</td>
      <td>{{ $barang->nama_barang }}</td>
    </tr>
    <tr>
      <td>Kategori</td>
      <td>:</td>
      <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
    </tr>
    <tr>
      <td>Berat/Vol</td>
      <td>:</td>
      <td>
        @if ($barang->kategori->hitung_berat)
          {{ $barang->berat }} kg
        @elseif ($barang->kategori->hitung_volume)
          {{ $barang->volume }} m³
        @else
          Flat Tarif
        @endif
      </td>
    </tr>
    <tr>
      <td>Deskripsi</td>
      <td>:</td>
      <td>{{ $barang->deskripsi_barang }}</td>
    </tr>
  </table>

  <div class="line"></div>

  <!-- Pengirim -->
  <div class="bold">PENGIRIM</div>
  <table>
    <tr>
      <td>Nama</td>
      <td>:</td>
      <td>{{ $barang->pengirim->nama }}</td>
    </tr>
    <tr>
      <td>Alamat</td>
      <td>:</td>
      <td>{{ $barang->pengirim->alamat }}</td>
    </tr>
    <tr>
      <td>No HP</td>
      <td>:</td>
      <td>{{ $barang->pengirim->no_hp }}</td>
    </tr>
  </table>

  <div class="line"></div>

  <!-- PENERIMA -->
  <div class="bold">PENERIMA</div>
  <table>
    <tr>
      <td>Nama</td>
      <td>:</td>
      <td>{{ $barang->penerima->nama }}</td>
    </tr>
    <tr>
      <td>Alamat</td>
      <td>:</td>
      <td>{{ $barang->penerima->alamat }}</td>
    </tr>
    <tr>
      <td>No HP</td>
      <td>:</td>
      <td>{{ $barang->penerima->no_hp }}</td>
    </tr>
  </table>

  <div class="line"></div>

  <!-- PROSES -->
  <div class="bold">PROSES</div>
  <table>
    <tr>
      <td>Staf</td>
      <td>:</td>
      <td>{{ $barang->pemrosessan->staf->nama ?? '-' }}</td>
    </tr>
    <tr>
      <td>Status</td>
      <td>:</td>
      <td>{{ $barang->pemrosessan->status_proses ?? '-' }}</td>
    </tr>
    <tr>
      <td>Catatan</td>
      <td>:</td>
      <td>{{ $barang->pemrosessan->catatan ?? '-' }}</td>
    </tr>
    <tr>
      <td>Estimasi</td>
      <td>:</td>
      <td>{{ date('d/m/Y H:i', strtotime($barang->pemrosessan->estimasi_waktu)) }}</td>
    </tr>
  </table>


  <div class="line"></div>

  <!-- Total Biaya -->
  <div class="bold text-right">Total Biaya: {{ format_rupiah($barang->total_tarif) }}</div>

  <div class="line"></div>

  <!-- Footer -->
  <div class="footer">Terima kasih telah menggunakan layanan kami!</div>

</body>

</html>
