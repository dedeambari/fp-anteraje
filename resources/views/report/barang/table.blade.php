<table id="barang" class="table table-hover align-items-center">
  <thead>
    <tr>
      <th>No resi</th>
      <th>Nama barang</th>
      <th>Status Barang</th>
      <th>Staf pengantar</th>
      <th>Tarif</th>
      <th>Status</th>
      <th>Waktu</th>
    </tr>
  </thead>
  <tbody>
    @forelse ($data as $dataBarang)
      <tr>
        <td>{{ $dataBarang->nomor_resi }}</td>
        <td>{{ $dataBarang->nama_barang }}</td>
        <td>{{ $dataBarang->pemrosessan->status_proses ?? '-' }}</td>
        <td>{{ $dataBarang->pemrosessan->staf->nama ?? '-' }}</td>
        <td>{{ format_rupiah($dataBarang->total_tarif) ?? 0 }}</td>
        <td class="text-capitalize">
          <div class="badge {{ $dataBarang->payment->status == 'sudah_bayar' ? 'bg-success' : 'bg-danger' }}">
            {{ preg_filter('/[^A-Za-z]/', ' ', $dataBarang->payment->status) ?? '-' }}
          </div>
        </td>
        <td>{{ $dataBarang->created_at->format('d/m/Y') }}</td>
      </tr>
    @empty
      <tr>
        <td colspan="11" class="text-center">Tidak ada data barang</td>
      </tr>
    @endforelse
    <tr class="table-total">
      <td colspan="6" class="text-end">Total</td>
      <td>{{ format_rupiah($data->sum('total_tarif')) ?? 0 }}</td>
    </tr>
  </tbody>
</table>

<style>
  th {
    text-align: center;
    vertical-align: middle;
    background-color: #F6C897FF;
    font-weight: bold;
    font-size: 14px;
    color: #000000;
  }

  .table-total td {
    background-color: #F6C897FF;
    font-weight: bold;
  }
</style>
