<div>
    <title>{{ config("app.name")}} - Tambah Barang</title>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{route("barang")}}">
                            <i class="bi bi-box2-fill" style="font-size: 1.2em"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{route("barang")}}">Barang</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah barang</li>
                </ol>
            </nav>
            <h2 class="h4">Tambah barang</h2>
        </div>
    </div>

    @if (session()->has('message'))
        <script>
            const notyf = new Notyf({
                position: {
                    x: 'right',
                    y: 'top',
                },
                types: [{
                    type: 'success',
                    icon: {
                        className: 'fas fa-check',
                        tagName: 'span',
                        color: '#fff'
                    },
                    dismissible: false
                }]
            });
            notyf.open({
                type: 'success',
                message: "{{ session('message') }}"
            });
        </script>
    @elseif (session()->has('error'))
        <script>
            const notyf = new Notyf({
                position: {
                    x: 'right',
                    y: 'top',
                },
                types: [{
                    type: 'error',
                    icon: {
                        className: 'fas fa-times',
                        tagName: 'span',
                        color: '#fff'
                    },
                    dismissible: false
                }]
            });
            notyf.open({
                type: 'error',
                message: "{{ session('error') }}"
            });
        </script>
    @endif

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center gap-4 mb-4">
        <div class="card card-body shadow border-0 table-wrapper table-responsive col-8">
            <span class="text-muted">Step {{ $currentPage }} / {{ count($page)}} ( {{$page[$currentPage ?? 0]["title"]}}
                )</span>
            <div>
                <form wire:submit.prevent="store" class="mt-4">
                    @if ($currentPage === 1)
                        <!-- Nama Barang -->
                        <div class="mb-3">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <input type="text" id="nama_barang" class="form-control" wire:model.lazy="namaBarang">
                            @error('namaBarang') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Kategori Barang -->
                        <div class="mb-3">
                            <label for="type_kategori" class="form-label">Kategori Barang</label>
                            <select id="type_kategori" class="form-control" wire:model.lazy="type_kategori">
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategori as $data_kategori)
                                    <option value="{{ $data_kategori->id_kategori }}">{{ $data_kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type_kategori') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Berat Barang -->
                        @if ($kategoriTerpilih && $kategoriTerpilih->hitung_berat)
                            <div class="mb-3">
                                <label for="berat_barang" class="form-label">Berat Barang (kg)</label>
                                <input type="number" id="berat_barang" class="form-control" wire:model.lazy="beratBarang">
                                @error('beratBarang') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        @endif

                        <!-- Volume Barang -->
                        @if ($kategoriTerpilih && $kategoriTerpilih->hitung_volume)
                            <div class="mb-3">
                                <label for="volume_barang" class="form-label">Volume Barang (m³)</label>
                                <input type="number" id="volume_barang" class="form-control" wire:model.lazy="volumeBarang">
                                @error('volumeBarang') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        @endif
                    @elseif ($currentPage === 2)
                        <!-- Nama Pengirim -->
                        <div class="mb-3">
                            <label for="nama_pengirim" class="form-label">Nama Pengirim</label>
                            <input type="text" id="nama_pengirim" class="form-control" wire:model.defer="namaPengirim">
                            @error('namaPengirim') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Alamat Pengirim -->
                        <div class="mb-3">
                            <label for="alamat_pengirim" class="form-label">Alamat Pengirim</label>
                            <textarea type="text" id="alamat_pengirim" class="form-control"
                                wire:model.defer="alamatPengirim"
                                placeholder="Jl. Jendral Sudirman, No. 123, Bandung, Jawa Barat"></textarea>
                            @error('alamatPengirim') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Nomor HP Pengirim -->
                        <div class="mb-3">
                            <label for="no_hp_pengirim" class="form-label">No. HP Pengirim</label>
                            <input type="number" id="no_hp_pengirim" class="form-control" wire:model.defer="noHpPengirim"
                                placeholder="081234567890">
                            @error('noHpPengirim') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    @elseif ($currentPage === 3)
                        <!-- Nama Penerima -->
                        <div class="mb-3">
                            <label for="nama_penerima" class="form-label">Nama Penerima</label>
                            <input type="text" id="nama_penerima" class="form-control" wire:model.defer="namaPenerima">
                            @error('namaPenerima') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Alamat Penerima -->
                        <div class="mb-3">
                            <label for="alamat_penerima" class="form-label">Alamat Penerima</label>
                            <textarea type="text" id="alamat_penerima" class="form-control"
                                wire:model.defer="alamatPenerima"
                                placeholder="Jl. Jendral Sudirman, No. 123, Bandung, Jawa Barat"></textarea>
                            @error('alamatPenerima') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Nomor HP Penerima -->
                        <div class="mb-3">
                            <label for="no_hp_penerima" class="form-label">No. HP Penerima</label>
                            <input type="number" id="no_hp_penerima" class="form-control" wire:model.defer="noHpPenerima">
                            @error('noHpPenerima') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    @elseif ($currentPage === 4)
                        <!-- Pilih Staf -->
                        <div class="mb-3">
                            <label for="stafPengantaran" class="form-label">Staf</label>
                            <select id="stafPengantaran" class="form-control" wire:model.lazy="stafPengantaran">
                                <option value="">Pilih Staf</option>
                                @foreach ($staf as $data_staf)
                                    <option value="{{ $data_staf->id }}">{{ $data_staf->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('stafPengantaran') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Estimasi Waktu -->
                        <div class="mb-3">
                            <label for="estimasi_waktu" class="form-label">Estimasi Waktu Pengantaran</label>
                            <input type="datetime-local" id="estimasi_waktu" class="form-control" wire:model.lazy="estimasiPengantaran">
                            @error('estimasiPengantaran') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea id="keterangan" class="form-control" wire:model.lazy="keterangan"></textarea>
                            @error('keterangan') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center">
                        @if ($currentPage > 1)
                            <button wire:click="previousStepPage" type="button" class="btn bg-gray-600 text-white">
                                <i class="bi bi-arrow-left"></i>
                            </button>
                        @endif
                        @if ($currentPage < count($page))
                            <div></div>
                            <button wire:click="nextStepPage" type="button" class="btn btn-primary">
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        @elseif ($currentPage === count($page))
                            <button type="submit" class="btn btn-primary">Tambah Barang</button>
                        @endif
                    </div>
                </form>

            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                const table = $("#staf tbody tr");
                $("#searchInput").on("keyup", function () {
                    const value = $(this).val().toLowerCase();
                    table.filter(function () {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                        // menampilkan tidak ada data
                    });
                });

                $("#type_kategori").on("change", function () {
                    const selectedValue = this.value;
                    Livewire.emit('selectKategori', selectedValue);
                });
            });
        </script>
    @endpush
</div>