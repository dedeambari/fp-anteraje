<form wire:submit.prevent="updatePengiriman" method="post">

  {{-- Pilih Staf --}}
  <div class="mb-3">
    <label for="pengiriman_staf" class="form-label">Staf</label>
    <select id="pengiriman" class="form-control" wire:model.lazy="pengiriman.id_staf">
      <option value="">Pilih Staf</option>
      @foreach ($staf as $data_staf)
        <option value="{{ $data_staf->id }}" @if (!empty($stafTerpilih) && $stafTerpilih->id_staf == $data_staf->id) selected @endif>
          {{ $data_staf->nama }}
        </option>
      @endforeach
    </select>
    @error('pengiriman.id_staf')
      <small class="text-danger">{{ $message ?? '' }}</small>
    @enderror
  </div>

  {{-- Porsess --}}
  <div class="mb-3">
    <label for="prosess" class="form-label">Status Prosess</label>
    <select id="prosess" class="form-control" wire:model.lazy="pengiriman.status_proses">
      <option value="">Pilih Prosess</option>
      <option value="diproses">Di proses</option>
      <option value="diantar">Di antar</option>
      <option value="diterima">Di terima</option>
    </select>
    @error('pengiriman.status_proses')
      <small class="text-danger">{{ $message ?? '' }}</small>
    @enderror
  </div>

  {{-- Estimasi Waktu --}}
  <div class="mb-3">
    <label for="estimasi_waktu" class="form-label">Estimasi Waktu Pengantaran</label>
    <input type="datetime-local" id="estimasi_waktu" class="form-control" wire:model.lazy="pengiriman.estimasi_waktu">
    @error('pengiriman.estimasi_waktu')
      <small class="text-danger">{{ $message ?? '' }}</small>
    @enderror
  </div>

  {{-- Catatan Pengiriman --}}
  <div class="mb-3">
    <label for="catatan" class="form-label">Catatan</label>
    <textarea id="catatan" class="form-control" wire:model.lazy="pengiriman.catatan"></textarea>
    @error('pengiriman.catatan')
      <small class="text-danger">{{ $message ?? '' }}</small>
    @enderror
  </div>

  {{-- Bukti Pengiriman --}}
  <div class="mb-3">
    <label for="bukti" class="form-label">
      Bukti Pengiriman
      @if ($buktiPreview)
        <small>
          <a class="link text-xs" href="{{ route('barang.bukti', $detailBarang->nomor_resi) }}" target="_blank">
            <i class="bi bi-file-earmark-image"></i> Bukti Sebelumnya
          </a>
        </small>
      @endif
    </label>
    <input type="file" accept="image/*" size="2048" id="bukti" class="form-control"
      wire:model.lazy="pengiriman.bukti">
    <div class="form-text d-flex flex-column gap-2">
      @error('pengiriman.bukti')
        <small class="text-danger">{{ $message ?? '' }}</small>
      @enderror
      <small class="text-muted">file tipe gambar. Maksimal ukuran gambar 2MB</small>
    </div>
  </div>

  <!-- Tombol Submit -->
  <div class="d-flex justify-content-end align-items-center">
    <button type="submit" class="btn btn-primary d-flex align-items-center gap-2" wire:loading.attr="disabled">
      Simpan
      <div wire:loading wire:target="updatePengiriman" class="text-muted">
        <div class="spinner-border spinner-border-sm" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
    </button>
  </div>
</form>
