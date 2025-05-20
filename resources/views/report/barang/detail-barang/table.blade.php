<table class="table table-bordered">
  <tbody>
    <tr class="table-secondary">
      <th colspan="2" height="25px" style="background-color: gray; text-align: center;">Informasi Barang</th>
    </tr>
    <tr>
      <th class="w-25">Nomor Resi</th>
      <td>{{ $data->nomor_resi }}</td>
    </tr>
    <tr>
      <th>Nama Barang</th>
      <td>{{ $data->nama_barang }}</td>
    </tr>
    <tr>
      <th>Kategori</th>
      <td>{{ $data->kategori->nama_kategori ?? '-' }}</td>
    </tr>
    @if ($data->kategori && $data->kategori->hitung_berat)
      <tr>
        <th>Berat Barang (kg)</th>
        <td>{{ intval($data->berat) }} Kg</td>
      </tr>
    @endif
    @if ($data->kategori && $data->kategori->hitung_volume)
      <tr>
        <th>Volume Barang (m<sup>3</sup>)</th>
        <td>{{ number_format($data->volume, 0) }} m<sup>3</sup></td>
      </tr>
    @endif
    <tr>
      <th>Deskripsi Barang</th>
      <td>{{ $data->deskripsi_barang }}</td>
    </tr>
    <tr>
      <th>Total Tarif Harga</th>
      <td>{{ format_rupiah($data->total_tarif) }}</td>
    </tr>

    {{-- Pengiriman --}}
    <tr class="table-secondary">
      <th colspan="2" height="25px" style="background-color: gray; text-align: center;">Informasi Pengiriman
        Barang</th>
    </tr>
    <tr>
      <th>Staf Pengirim</th>
      <td>{{ $data->pemrosessan->staf->nama ?? '-' }}</td>
    </tr>
    <tr>
      <th>Status Proses</th>
      <td>{{ $data->pemrosessan->status_proses ?? '-' }}</td>
    </tr>
    <tr>
      <th>Tanggal Proses</th>
      <td>{{ date_format($data->pemrosessan->created_at, 'd/m/Y H:i') ?? '-' }}</td>
    </tr>
    <tr>
      <th>Estimasi Sampai</th>
      <td>{{ date('d/m/Y H:i', strtotime($data->estimasi_waktu)) ?? '-' }}</td>
    </tr>
    <tr>
      <th>Catatan Pengiriman</th>
      <td>{{ $data->pemrosessan->catatan ?? '-' }}</td>
    </tr>
    <tr>
      <th>Bukti Pengiriman Sampai</th>
      <td>
        @if ($data->pemrosessan->bukti)
          <a href="{{ route('barang.bukti', $data->nomor_resi) }}" target="_blank">
            <i class="bi bi-file-earmark-image"></i> Lihat Bukti
          </a>
        @else
          -
        @endif
      </td>
    </tr>

    {{-- Pengirim --}}
    <tr class="table-secondary">
      <th colspan="2" height="25px" style="background-color: gray; text-align: center;">Informasi Pengirim</th>
    </tr>
    <tr>
      <th>Nama Pengirim</th>
      <td>{{ $data->pengirim->nama ?? '-' }}</td>
    </tr>
    <tr>
      <th>Alamat Pengirim</th>
      <td>{{ $data->pengirim->alamat ?? '-' }}</td>
    </tr>
    <tr>
      <th>No. HP Pengirim</th>
      <td>{{ $data->pengirim->no_hp ?? '-' }}</td>
    </tr>

    {{-- Penerima --}}
    <tr class="table-secondary">
      <th colspan="2" height="25px" style="background-color: gray; text-align: center;">Informasi Penerima</th>
    </tr>
    <tr>
      <th>Nama Penerima</th>
      <td>{{ $data->penerima->nama ?? '-' }}</td>
    </tr>
    <tr>
      <th>Alamat Penerima</th>
      <td>{{ $data->penerima->alamat ?? '-' }}</td>
    </tr>
    <tr>
      <th>No. HP Penerima</th>
      <td>{{ $data->penerima->no_hp ?? '-' }}</td>
    </tr>

    {{-- Pembayaran --}}
    <tr class="table-secondary">
      <th colspan="2" height="25px" style="background-color: gray; text-align: center;">Informasi Pembayaran</th>
    </tr>
    <tr class="table-warning">
      <th>Yang Membayar</th>
      <td class="text-capitalize">{{ $data->payment->pays ?? '-' }} Barang</td>
    </tr>
    <tr class="table-warning">
      <th>Status Pembayaran</th>
      <td
        class="text-capitalize {{ $data->payment->status == 'sudah_bayar' ? 'text-success' : 'text-danger' }}">
        {{ preg_filter('/[^A-Za-z]/', ' ', $data->payment->status) ?? '-' }}
      </td>
    </tr>
  </tbody>
</table>

<style>
  .table-secondary {
    background-color: #f2f2f2;
  }

  .table-warning {
    background-color: #fff3cd;
  }

  .text-capitalize {
    text-transform: capitalize;
  }

  .text-success {
    color: rgb(12, 132, 12);
  }

  .text-danger {
    color: red;
  }
</style>
