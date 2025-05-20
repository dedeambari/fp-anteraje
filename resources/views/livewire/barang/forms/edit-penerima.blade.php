<form wire:submit.prevent="updatePenerima" method="post">

  <!-- Nama Penerima -->
  <div class="mb-3">
    <label for="nama_penerima" class="form-label">Nama Penerima</label>
    <input type="text" id="nama_penerima" class="form-control" wire:model.defer="penerima.nama">
    @error('penerima.nama')
      <small class="text-danger">{{ $message ?? '' }}</small>
    @enderror
  </div>

  <!-- Alamat Penerima -->
  <div class="mb-3">
    <label for="alamat_penerima" class="form-label">Alamat Penerima</label>
    <textarea type="text" id="alamat_penerima" class="form-control" wire:model.defer="penerima.alamat"
      placeholder="Jl. Jendral Sudirman, No. 123, Bandung, Jawa Barat"></textarea>
    @error('penerima.alamat"')
      <small class="text-danger">{{ $message ?? '' }}</small>
    @enderror
  </div>

  <!-- Nomor HP Penerima -->
  <div class="mb-3">
    <label for="no_hp_penerima" class="form-label">No. HP Penerima</label>
    <input type="number" id="no_hp_penerima" class="form-control" wire:model.defer="penerima.no_hp"
      placeholder="081234567890">
    @error('penerima.no_hp')
      <small class="text-danger">{{ $message ?? '' }}</small>
    @enderror
  </div>

  <!-- Tombol Submit -->
  <div class="d-flex justify-content-end align-items-center">
    <button type="submit" class="btn btn-primary d-flex align-items-center gap-2" wire:loading.attr="disabled">
      Simpan
      <div wire:loading wire:target="updatePenerima" class="text-muted">
        <div class="spinner-border spinner-border-sm" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
    </button>
  </div>
</form>
