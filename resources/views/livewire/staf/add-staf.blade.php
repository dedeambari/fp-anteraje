<div>
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
      <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
          <li class="breadcrumb-item">
            <a href="{{ route('staf') }}">
              <i class="bi bi-person-badge-fill" style="font-size: 1.2em"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="{{ route('staf') }}">Staf</a></li>
          <li class="breadcrumb-item active" aria-current="page">Tambah Staf</li>
        </ol>
      </nav>
      <h2 class="h4">Tambah Staf</h2>
    </div>
  </div>


  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center gap-4 mb-4">
    <div class="card card-body shadow border-0 table-wrapper table-responsive col-8">
      <div>
        <form wire:submit.prevent="store" action="#" class="mt-4" method="POST">
          <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" placeholder="John Thooor" wire:model="nama">
            @error('nama')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-3">
            <label for="phone" class="form-label">Nomor Handphone</label>
            <input type="number" class="form-control" id="phone" placeholder="08xxxxxxx" wire:model="noHp">
            @error('noHp')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-3">
            <select name="transportasi" wire:model="transportasi" id="transportasi" class="form-control">
              <option value="">Pilih</option>
              <option value="motor">Motor</option>
              <option value="mobil">Mobil</option>
            </select>
            @error('transportasi')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-3">
            <label for="jumlah_tugas" class="form-label">Jumlah Tugas</label>
            <input type="number" class="form-control" id="jumlah_tugas" placeholder="10" wire:model="jumlah_tugas">
            @error('jumlah_tugas')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <button type="submit" class="btn btn-primary">Save</button>
        </form>
      </div>
    </div>
  </div>

</div>
