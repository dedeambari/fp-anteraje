<div>
  <title>{{ config('app.name') }} - Barang</title>
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4">
    <div class="d-block mb-4 mb-md-0">
      <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
          <li class="breadcrumb-item">
            <a href="{{ route('barang') }}">
              <i class="bi bi-box2-fill" style="font-size: 1.2em"></i>
            </a>
          </li>
          <li class="breadcrumb-item active"><a href="{{ route('barang') }}">Barang</a></li>
        </ol>
      </nav>
      <h2 class="h4">List Barang</h2>
    </div>
  </div>

  <div class="table-settings mb-4 border-top border-2 pt-4">

    <!-- Baris Atas: Search + Tombol -->
    <div class="row mb-3 align-items-center">
      <div class="col-md-4 col-12 mb-2 mb-md-0">
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-search"></i></span>
          <input type="text" class="form-control" placeholder="Search barang" id="searchInput">
        </div>
      </div>
      <div class="col-md-8 col-12 d-flex justify-content-end gap-2">
        <div class="btn-group">
          <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
            Export
          </button>
          <ul class="dropdown-menu">
            {{-- <li><a class="dropdown-item" wire:click="exportExcel()">Export to Excel</a></li> --}}
            <li>
            <li>
              <a href="{{ route('barang.excel', [
                  'status_prosess' => $statusProsess,
                  'status_bayar' => $statusBayar,
                  'status_kategori' => $statuskategori,
                  'dateFrom' => $dateFrom,
                  'dateTo' => $dateTo,
                  'fileNameExport' => $fileNameExport,
              ]) }}"
                class="dropdown-item" target="_blank">
                Export to Excel
              </a>
            </li>

            </li>
            <li>
              <a href="{{ route('barang.pdf', [
                  'status_prosess' => $statusProsess,
                  'status_bayar' => $statusBayar,
                  'status_kategori' => $statuskategori,
                  'dateFrom' => $dateFrom,
                  'dateTo' => $dateTo,
              ]) }}"
                class="dropdown-item" target="_blank">
                Export to PDF
              </a>
            </li>
          </ul>
        </div>
        <a href="{{ route('barang.add') }}" class="btn btn-primary btn-sm">
          <div class="position-relative d-flex align-items-center">
            <i class="bi bi-box-seam-fill me-2"></i>
            <i class="fas fa-plus-circle"></i>
          </div>
        </a>
      </div>
    </div>

    <!-- Baris Bawah: Filter-Filter -->
    <div class="row g-3">
      <!-- Bayar -->
      <div class="col-md-2 col-6">
        <select class="form-select" id="statusFilterBayar" wire:click="$emit('statusFilterBayar', $event.target.value)">
          <option value="">Status Bayar</option>
          <option value="sudah_bayar">Sudah Bayar</option>
          <option value="belum_bayar">Belum Bayar</option>
        </select>
      </div>

      <!-- Proses -->
      <div class="col-md-2 col-6">
        <select class="form-select" id="statusFilterProsess"
          wire:click="$emit('statusFilterProsess', $event.target.value)">
          <option value="">Status Proses</option>
          <option value="diproses">Di Proses</option>
          <option value="diantar">Di Antar</option>
          <option value="diterima">Di Terima</option>
        </select>
      </div>

      <!-- Tanggal -->
      <div class="col-md-5 col-12">
        <div class="input-group">
          <input type="date" class="form-control" id="dateInputFrom">
          <span class="input-group-text">→</span>
          <input type="date" class="form-control" id="dateInputTo">
        </div>
      </div>

      <!-- Kategori -->
      <div class="col-md-3 col-12">
        <select class="form-select" id="statusFilterKategori"
          wire:click="$emit('statusFilterKategori', $event.target.value)">
          <option value="">Kategori</option>
          @foreach ($kategori as $data)
            <option value="{{ $data->id_kategori }}">{{ $data->nama_kategori }}</option>
          @endforeach
        </select>
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

  <div class="card bg-white shadow border-0 table-wrapper mb-4 table-responsive">
    <table id="barang" class="table table-hover align-items-center">
      <thead>
        <tr>
          <th>No resi</th>
          <th>Nama barang</th>
          <th>Status Barang</th>
          <th>Staf pengantar</th>
          <th>Tarif</th>
          <th>Pembayaran</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($barang as $data)
          <tr class="detail cursor-pointer" data-nomor_resi="{{ $data->nomor_resi }}" style="cursor: pointer;">
            <td>{{ $data->nomor_resi }}</td>
            <td>{{ $data->nama_barang }}</td>
            <td>{{ $data->pemrosessan->status_proses ?? '-' }}</td>
            <td>{{ $data->pemrosessan->staf->nama ?? '-' }}</td>
            <td>{{ format_rupiah($data->total_tarif) ?? 0 }}</td>
            <td class="text-capitalize text-center">
              <div
                class="badge rounded-pill text-center {{ $data->payment->status == 'sudah_bayar' ? 'bg-success' : 'bg-danger' }}">
                @if ($data->payment->status == 'sudah_bayar')
                  <i class="fas fa-check"></i>
                @else
                  <i class="fas fa-times"></i>
                @endif
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="11" class="text-center">Tidak ada data barang</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  {{ $barang->links('vendor.pagination.bootstrap-5') }}
  @push('scripts')
    <script>
      $(document).ready(function() {
        const table = $("#barang tbody tr");
        $("#searchInput").on("keyup", function() {
          const value = $(this).val().toLowerCase();
          table.filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            // menampilkan tidak ada data
          });
        });

        // Gunakan event delegation untuk menangani klik pada tombol deleted permanent
        $(document).on('click', '.delete', function() {
          const barangId = $(this).data('barangxid');

          Swal.fire({
            title: 'Menghapus secara permanen barang ini?',
            icon: 'warning',
            showCancelButton: true,
            customClass: {
              confirmButton: 'btn btn-danger',
              cancelButton: 'btn btn-gray'
            },
            confirmButtonText: 'Yes, i"m sure!'
          }).then((result) => {
            if (result.isConfirmed) {
              Livewire.emit('deletebarang', barangId);
            }
          });
        });

        $(document).on('click', '.detail', function() {
          const nomorResi = $(this).data('nomor_resi');
          window.location.href = "{{ route('barang.detail', ':nomor_resi') }}".replace(':nomor_resi', nomorResi);
        })

        function checkAndEmit() {
          var from = $('#dateInputFrom').val();
          var to = $('#dateInputTo').val();

          if (from && to) {
            Livewire.emit('filterByDateRange', {
              dateFrom: from,
              dateTo: to
            });
          }
        }

        $('#dateInputFrom, #dateInputTo').on('change', checkAndEmit);
      });
    </script>
  @endpush
</div>
