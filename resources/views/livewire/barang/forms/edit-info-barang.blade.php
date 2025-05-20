<form wire:submit.prevent="updateInfoBarang" method="post">
  <!-- Nama Barang -->
  <div class="mb-3">
    <label for="nama_barang" class="form-label">Nama Barang</label>
    <input type="text" id="nama_barang" class="form-control" wire:model.lazy="barang.nama_barang">
    @error('barang.nama_barang')
      <small class="text-danger">{{ $message }}</small>
    @enderror
  </div>

  <!-- Kategori Barang -->
  <div class="mb-3">
    <label for="id_kategori" class="form-label">Kategori Barang</label>
    <select id="id_kategori" class="form-control" wire:change="$emit('selectKategori', $event.target.value)">
      <option value="">Pilih Kategori</option>
      @foreach ($kategori as $data_kategori)
        <option value="{{ $data_kategori->id_kategori }}"
        @if (!empty($kategoriTerpilih) && $kategoriTerpilih->id_kategori == $data_kategori->id_kategori)
          selected
        @endif
        >
          {{ $data_kategori->nama_kategori }}
        </option>
      @endforeach
    </select>
    @error('barang.id_kategori')
      <small class="text-danger">{{ $message }}</small>
    @enderror
  </div>

  <!-- Berat Barang -->
  @if (!empty($kategoriTerpilih) && $kategoriTerpilih->hitung_berat)
    <div class="mb-3">
      <label for="berat" class="form-label">Berat Barang (kg)</label>
      <input type="number" id="berat" class="form-control" wire:model.lazy="barang.berat">
      @error('barang.berat')
        <small class="text-danger">{{ $message ?? '' }}</small>
      @enderror

      <div class="my-2">
        <table class="table table-sm table-bordered">
          <tr>
            <th class="col py-2">Tarif Flat</th>
            <th class="col py-2">Biaya Tambahan</th>
          </tr>
          <tr>
            <td>{{ format_rupiah($kategoriTerpilih->tarif_flat) }}</td>
            <td>{{ format_rupiah($kategoriTerpilih->biaya_tambahan) }}</td>
          </tr>
        </table>
      </div>
    </div>
  @endif

  <!-- Volume Barang -->
  @if (!empty($kategoriTerpilih) && $kategoriTerpilih->hitung_volume)
    <div class="mb-3">
      <label for="volume" class="form-label">Volume Barang (m³)</label>
      <input type="number" id="volume" class="form-control" wire:model.lazy="barang.volume">
      @error('barang.volume')
        <small class="text-danger">{{ $message ?? '' }}</small>
      @enderror

      <div class="my-2">
        <table class="table table-sm table-bordered">
          <tr>
            <th class="col py-2">Tarif Flat</th>
            <th class="col py-2">Biaya Tambahan</th>
          </tr>
          <tr>
            <td>{{ format_rupiah($kategoriTerpilih->tarif_flat) }}</td>
            <td>{{ format_rupiah($kategoriTerpilih->biaya_tambahan) }}</td>
          </tr>
        </table>
      </div>
    </div>
  @endif

  <!-- Jika Tidak Menghitung Berat & Volume -->
  @if (
      !empty($kategoriTerpilih) &&
          !$kategoriTerpilih->hitung_berat &&
          !$kategoriTerpilih->hitung_volume)
    <div class="mb-3">
      <div class="my-2">
        <table class="table table-sm table-bordered">
          <thead>
            <tr>
              <th class="col py-2">Tarif Flat</th>
              <th class="col py-2">Biaya Tambahan</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{ format_rupiah($kategoriTerpilih->tarif_flat) }}</td>
              <td>{{ format_rupiah($kategoriTerpilih->biaya_tambahan) }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  @endif

  <!-- Deskripsi -->
  <div class="mb-3">
    <label for="deskripsi_barang" class="form-label">Deskripsi</label>
    <textarea id="deskripsi_barang" class="form-control" wire:model.lazy="barang.deskripsi_barang"></textarea>
    @error('barang.deskripsi_barang')
      <small class="text-danger">{{ $message }}</small>
    @enderror
  </div>

  <!-- Tombol Submit -->
  <div class="d-flex justify-content-end align-items-center">
    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
      Simpan
      <div wire:loading wire:target="updateInfoBarang" class="text-muted mt-2">
        <div class="spinner-border spinner-border-sm" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
    </button>
  </div>
</form>
