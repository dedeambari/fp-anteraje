<form wire:submit.prevent="updatePengirim" method="post">

  <!-- Nama Pengirim -->
  <div class="mb-3">
    <label for="nama_pengirim" class="form-label">Nama Pengirim</label>
    <input type="text" id="nama_pengirim" class="form-control" wire:model.defer="pengirim.nama">
    @error('pengirim.nama')
      <small class="text-danger">{{ $message ?? '' }}</small>
    @enderror
  </div>

  <!-- Alamat Pengirim -->
  <div class="mb-3">
    <label for="alamat_pengirim" class="form-label">Alamat Pengirim</label>
    <textarea type="text" id="alamat_pengirim" class="form-control" wire:model.defer="pengirim.alamat"
      placeholder="Jl. Jendral Sudirman, No. 123, Bandung, Jawa Barat"></textarea>
    @error('pengirim.alamat"')
      <small class="text-danger">{{ $message ?? '' }}</small>
    @enderror
  </div>

  <!-- Nomor HP Pengirim -->
  <div class="mb-3">
    <label for="no_hp_pengirim" class="form-label">No. HP Pengirim</label>
    <input type="number" id="no_hp_pengirim" class="form-control" wire:model.defer="pengirim.no_hp"
      placeholder="081234567890">
    @error('pengirim.no_hp')
      <small class="text-danger">{{ $message ?? '' }}</small>
    @enderror
  </div>

  <!-- Tombol Submit -->
  <div class="d-flex justify-content-end align-items-center">
    <button type="submit" class="btn btn-primary d-flex align-items-center gap-2" wire:loading.attr="disabled">
      Simpan
      <div wire:loading wire:target="updatePengirim" class="text-muted">
        <div class="spinner-border spinner-border-sm" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
    </button>
  </div>
</form>
