<form wire:submit.prevent="updatePembayaran" method="post">

  <!-- Yang Membayar -->
  <div class="mb-3">
    <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
    <select wire:model.defer="pembayaran.pays" name="metode_pembayaran" class="form-control" id="metode_pembayaran">
      <option value="">Pilih Bayaran</option>
      <option value="pengirim">Pengirim Barang</option>
      <option value="penerima">Penerima Barang</option>
    </select>
    @error('pembayaran.pays')
      <small class="text-danger">{{ $message }}</small>
    @enderror
  </div>

  <!-- Status Pembayaran -->
  <div class="mb-3">
    <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
    <select wire:model.defer="pembayaran.status" name="status_pembayaran" class="form-control" id="status_pembayaran">
      <option value="">Pilih Status</option>
      <option value="belum_bayar">Belum Bayar</option>
      <option value="sudah_bayar">Sudah Bayar</option>
    </select>
    @error('pembayaran.status')
      <small class="text-danger">{{ $message }}</small>
    @enderror
  </div>

  <!-- Tombol Submit -->
  <div class="d-flex justify-content-end align-items-center">
    <button type="submit" class="btn btn-primary d-flex align-items-center gap-2" wire:loading.attr="disabled">
      Simpan
      <div wire:loading wire:target="updatePembayaran" class="text-muted">
        <div class="spinner-border spinner-border-sm" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
    </button>
  </div>
</form>
