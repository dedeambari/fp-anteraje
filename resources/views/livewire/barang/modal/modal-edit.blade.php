<div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit {{ ucwords(str_replace('-', ' ', $modalType)) }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        @switch($modalType)
          @case('info-barang')
            @include('livewire.barang.forms.edit-info-barang')
          @break

          @case('pengirim')
            @include('livewire.barang.forms.edit-pengirim')
          @break

          @case('penerima')
            @include('livewire.barang.forms.edit-penerima')
          @break

          @case('pengiriman')
            @include('livewire.barang.forms.edit-pengiriman')
          @break

          @case('pembayaran')
            @include('livewire.barang.forms.edit-pembayaran')
          @break

          @default
            <div class="spinner-border" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          @break
        @endswitch
      </div>
    </div>
  </div>
</div>
