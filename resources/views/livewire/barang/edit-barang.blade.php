<div>
  <title>{{ config('app.name', 'Laravel') }} - Edit barang</title>
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
      <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
          <li class="breadcrumb-item">
            <a href="{{ route('barang') }}">
              <i class="bi bi-person-badge-fill" style="font-size: 1.2em"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="{{ route('barang') }}">Barang</a></li>
          <li class="breadcrumb-item" aria-current="page">
            <a href="{{ route('barang.detail', $dataBarang->nomor_resi) }}">
              {{ $dataBarang->nomor_resi }}
            </a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Edit barang</li>
        </ol>
      </nav>
      <h2 class="h4">Edit Barang <span style="text-decoration: underline">{{ $dataBarang->nama_barang }}</span></h2>
    </div>
  </div>


  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center gap-4">
    <div class="card card-body shadow border-0 table-wrapper table-responsive col-8">
      <div>
        <form wire:submit.prevent="updateAllData" method="post">

          {{-- Informasi Barang --}}
          <div class="mb-3">
            <label for="nama_barang" class="form-label">Nama Barang</label>
            <input type="text" id="nama_barang" class="form-control" wire:model.lazy="nama_barang">
            @error('nama_barang')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3">
            <label for="id_kategori" class="form-label">Kategori Barang</label>
            <select id="id_kategori" class="form-control" wire:change="$emit('selectKategori', $event.target.value)"
              wire:model="id_kategori">
              <option value="">Pilih Kategori</option>
              @foreach ($kategori as $data_kategori)
                <option value="{{ $data_kategori->id_kategori }}" @if (!empty($kategoriTerpilih) && $kategoriTerpilih->id_kategori == $data_kategori->id_kategori) selected @endif>
                  {{ $data_kategori->nama_kategori }}
                </option>
              @endforeach
            </select>
            @error('id_kategori')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          @if (!empty($kategoriTerpilih) && $kategoriTerpilih->hitung_berat)
            <div class="mb-3">
              <label for="berat" class="form-label">Berat Barang (kg)</label>
              <input type="number" id="berat" class="form-control" wire:model.lazy="berat">
              @error('berat')
                <small class="text-danger">{{ $message ?? '' }}</small>
              @enderror
              <div class="my-2">
                <table class="table table-sm table-bordered">
                  <tr>
                    <th>Tarif Flat</th>
                    <th>Biaya Tambahan</th>
                  </tr>
                  <tr>
                    <td>{{ format_rupiah($kategoriTerpilih->tarif_flat) }}</td>
                    <td>{{ format_rupiah($kategoriTerpilih->biaya_tambahan) }}</td>
                  </tr>
                </table>
              </div>
            </div>
          @endif

          @if (!empty($kategoriTerpilih) && $kategoriTerpilih->hitung_volume)
            <div class="mb-3">
              <label for="volume" class="form-label">Volume Barang (m³)</label>
              <input type="number" id="volume" class="form-control" wire:model.lazy="volume">
              @error('volume')
                <small class="text-danger">{{ $message ?? '' }}</small>
              @enderror
              <div class="my-2">
                <table class="table table-sm table-bordered">
                  <tr>
                    <th>Tarif Flat</th>
                    <th>Biaya Tambahan</th>
                  </tr>
                  <tr>
                    <td>{{ format_rupiah($kategoriTerpilih->tarif_flat) }}</td>
                    <td>{{ format_rupiah($kategoriTerpilih->biaya_tambahan) }}</td>
                  </tr>
                </table>
              </div>
            </div>
          @endif

          @if (!empty($kategoriTerpilih) && !$kategoriTerpilih->hitung_berat && !$kategoriTerpilih->hitung_volume)
            <div class="mb-3">
              <div class="my-2">
                <table class="table table-sm table-bordered">
                  <tr>
                    <th>Tarif Flat</th>
                    <th>Biaya Tambahan</th>
                  </tr>
                  <tr>
                    <td>{{ format_rupiah($kategoriTerpilih->tarif_flat) }}</td>
                    <td>{{ format_rupiah($kategoriTerpilih->biaya_tambahan) }}</td>
                  </tr>
                </table>
              </div>
            </div>
          @endif

          <div class="mb-3">
            <label for="deskripsi_barang" class="form-label">Deskripsi</label>
            <textarea id="deskripsi_barang" class="form-control" wire:model.lazy="deskripsi_barang"></textarea>
            @error('deskripsi_barang')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          {{-- Pengiriman --}}
          <div class="mb-3">
            <label for="pengiriman_staf" class="form-label">Staf</label>
            <select id="pengiriman_staf" class="form-control" wire:model.lazy="id_staf">
              <option value="">Pilih Staf</option>
              @foreach ($staf as $data_staf)
                <option value="{{ $data_staf->id }}" @if (!empty($stafTerpilih) && $stafTerpilih->id_staf == $data_staf->id) selected @endif>
                  {{ $data_staf->nama }}
                </option>
              @endforeach
            </select>
            @error('id_staf')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3">
            <label for="prosess" class="form-label">Status Prosess</label>
            <select id="prosess" class="form-control" wire:model.lazy="status_proses">
              <option value="">Pilih Prosess</option>
              <option value="diproses">Di proses</option>
              <option value="diantar">Di antar</option>
              <option value="diterima">Di terima</option>
            </select>
            @error('status_proses')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3">
            <label for="estimasi_waktu" class="form-label">Estimasi Waktu Pengantaran</label>
            <input type="datetime-local" id="estimasi_waktu" class="form-control" wire:model.lazy="estimasi_waktu">
            @error('estimasi_waktu')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3">
            <label for="catatan" class="form-label">Catatan</label>
            <textarea id="catatan" class="form-control" wire:model.lazy="catatan"></textarea>
            @error('catatan')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3">
            <label for="bukti" class="form-label">
              Bukti Pengiriman
              @if ($buktiPreview)
                <small>
                  <a class="link text-xs" href="{{ route('barang.bukti', $dataBarang->nomor_resi) }}"
                    target="_blank">
                    <i class="bi bi-file-earmark-image"></i> Bukti Sebelumnya
                  </a>
                </small>
              @endif
            </label>
            <input type="file" accept="image/*" size="2048" id="bukti" class="form-control"
              wire:model.lazy="bukti">
            <div class="form-text d-flex flex-column gap-2">
              @error('bukti')
                <small class="text-danger">{{ $message ?? '' }}</small>
              @enderror
              <small class="text-muted">file tipe gambar. Maksimal ukuran gambar 2MB</small>
            </div>
          </div>

          {{-- Pengirim --}}
          <div class="mb-3">
            <label for="nama_pengirim" class="form-label">Nama Pengirim</label>
            <input type="text" id="nama_pengirim" class="form-control" wire:model.defer="pengirim_nama">
            @error('pengirim_nama')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3">
            <label for="alamat_pengirim" class="form-label">Alamat Pengirim</label>
            <textarea id="alamat_pengirim" class="form-control" wire:model.defer="pengirim_alamat"></textarea>
            @error('pengirim_alamat')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3">
            <label for="no_hp_pengirim" class="form-label">No. HP Pengirim</label>
            <input type="number" id="no_hp_pengirim" class="form-control" wire:model.defer="pengirim_no_hp">
            @error('pengirim_no_hp')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          {{-- Penerima --}}
          <div class="mb-3">
            <label for="nama_penerima" class="form-label">Nama Penerima</label>
            <input type="text" id="nama_penerima" class="form-control" wire:model.defer="penerima_nama">
            @error('penerima_nama')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3">
            <label for="alamat_penerima" class="form-label">Alamat Penerima</label>
            <textarea id="alamat_penerima" class="form-control" wire:model.defer="penerima_alamat"></textarea>
            @error('penerima_alamat')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3">
            <label for="no_hp_penerima" class="form-label">No. HP Penerima</label>
            <input type="number" id="no_hp_penerima" class="form-control" wire:model.defer="penerima_no_hp">
            @error('penerima_no_hp')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          {{-- Pembayaran --}}
          <div class="mb-3">
            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
            <select wire:model.defer="pays" class="form-control" id="metode_pembayaran">
              <option value="">Pilih Bayaran</option>
              <option value="pengirim">Pengirim Barang</option>
              <option value="penerima">Penerima Barang</option>
            </select>
            @error('pays')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="mb-3">
            <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
            <select wire:model.defer="status" class="form-control" id="status_pembayaran">
              <option value="">Pilih Status</option>
              <option value="belum_bayar">Belum Bayar</option>
              <option value="sudah_bayar">Sudah Bayar</option>
            </select>
            @error('status')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          {{-- Tombol Submit --}}
          <div class="d-flex justify-content-end align-items-center">
            <button type="submit" class="btn btn-primary d-flex align-items-center gap-2"
              wire:loading.attr="disabled">
              Simpan
              <div wire:loading wire:target="updateAllData" class="text-muted">
                <div class="spinner-border spinner-border-sm" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>
            </button>
          </div>
        </form>
      </div>
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
</div>
