<div>
    <title>Laundry - Edit Staf</title>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route("staf")}}">
                            <i class="bi bi-person-badge-fill" style="font-size: 1.2em"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route("staf")}}">Staf</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Staf</li>
                </ol>
            </nav>
            <h2 class="h4">Edit Staf <span style="text-decoration: underline">{{ $nama }}</span></h2>
        </div>
    </div>


    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center gap-4">
        <div class="card card-body shadow border-0 table-wrapper table-responsive col-8">
            <div>
                <form wire:submit.prevent="edit" action="#" class="mt-4" method="POST"> <!-- Form -->
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input value="{{ $nama }}" type="text" class="form-control" id="nama" placeholder="John Thooor"
                            wire:model="nama">
                        @error('nama')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Nomor Handphone</label>
                        <input value="{{ $noHp }}" type="number" class="form-control" id="phone" placeholder="08xxxxxxx"
                            wire:model="noHp">
                        @error('noHp')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="transportasi" class="form-label">Transportasi</label>
                        <input value="{{ $transportasi }}" type="text" class="form-control" id="transportasi"
                            placeholder="Kendaraan" wire:model="transportasi">
                        @error('transportasi')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_tugas" class="form-label">Jumlah Tugas</label>
                        <input value="{{ $jumlah_tugas }}" type="number" class="form-control" id="jumlah_tugas"
                            placeholder="10" wire:model="jumlah_tugas">
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