<div>
    <title>Laundry - Edit kategori</title>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route("kategori")}}">
                            <i class="bi bi-person-badge-fill" style="font-size: 1.2em"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route("kategori")}}">kategori</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit kategori</li>
                </ol>
            </nav>
            <h2 class="h4">Edit kategori <span style="text-decoration: underline">{{ $nama_kategori }}</span></h2>
        </div>
    </div>


    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center gap-4">
        <div class="card card-body shadow border-0 table-wrapper table-responsive col-8">
            <div>
                <form wire:submit.prevent="edit" action="#" class="mt-4" method="POST">
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama_kategori" placeholder="Contoh: Kiloan"
                            name="nama_kategori" value="{{ $nama_kategori }}" wire:model="nama_kategori">
                        @error('nama_kategori')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Hitung Berat</label>
                        <select class="form-select" name="hitung_berat" wire:model="hitung_berat">
                            <option value="">Pilih</option>
                            <option value="1" @if($hitung_berat == 1) selected @endif>Ya</option>
                            <option value="0" @if($hitung_berat == 0) selected @endif>Tidak</option>
                        </select>
                        @error('hitung_berat')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Hitung Volume</label>
                        <select class="form-select" name="hitung_volume" wire:model="hitung_volume">
                            <option value="">Pilih</option>
                            <option value="1" @if($hitung_volume == 1) selected @endif>Ya</option>
                            <option value="0" @if($hitung_volume == 0) selected @endif>Tidak</option>
                        </select>
                        @error('hitung_volume')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        @if($hitung_berat == 1)
                            <label for="tarif_per_kg" class="form-label">Tarif per Kg</label>
                            <input type="number" step="0.01" class="form-control" id="tarif_per_kg" name="tarif_per_kg"
                                placeholder="Contoh: 10000" value="{{ $tarif_per_kg }}" wire:model="tarif_per_kg">
                        @endif
                        @error('tarif_per_kg')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        @if($hitung_volume == 1)
                            <label for="tarif_per_m3" class="form-label">Tarif per m³</label>
                            <input type="number" step="0.01" class="form-control" id="tarif_per_m3" name="tarif_per_m3"
                                placeholder="Contoh: 50000" value="{{ $tarif_per_m3 }}" wire:model="tarif_per_m3">
                        @endif
                        @error('tarif_per_m3')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tarif_flat" class="form-label">Tarif Flat</label>
                        <input type="number" step="0.01" class="form-control" id="tarif_flat" name="tarif_flat"
                            placeholder="Contoh: 20000" value="{{ $tarif_flat }}" wire:model="tarif_flat">
                        @error('tarif_flat')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="biaya_tambahan" class="form-label">Biaya Tambahan</label>
                        <input type="number" step="0.01" class="form-control" id="biaya_tambahan" name="biaya_tambahan"
                            placeholder="Contoh: 5000" value="{{ $biaya_tambahan }}" wire:model="biaya_tambahan">
                        @error('biaya_tambahan')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update Kategori</button>
                </form>

            </div>
        </div>
    </div>

</div>