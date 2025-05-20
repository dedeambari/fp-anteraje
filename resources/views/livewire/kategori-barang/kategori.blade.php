<div>
  <title>{{ config('app.name') }} - Kategori barang</title>
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4">
    <div class="d-block mb-4 mb-md-0">
      <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
          <li class="breadcrumb-item">
            <a href="{{ route('kategori') }}">
              <i class="bi bi-card-list" style="font-size: 1.2em"></i>
            </a>
          </li>
          <li class="breadcrumb-item active"><a href="{{ route('kategori') }}">kategori</a></li>
        </ol>
      </nav>
      <h2 class="h4">List kategori</h2>
    </div>
  </div>
  <div class="table-settings mb-4 border-top border-2 pt-4">
    <div class="row justify-content-between align-items-center">
      <div class="col-9 col-lg-8 d-md-flex">
        <div class="input-group me-2 me-lg-3 fmxw-300 mb-2 mb-lg-0">
          <span class="input-group-text">
            <svg class="icon icon-xs" x-description="Heroicon name: solid/search" xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd"
                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                clip-rule="evenodd"></path>
            </svg>
          </span>
          <input type="text" class="form-control" placeholder="Search kategori" id="searchInput">
        </div>
        <a href="{{ route('kategori.add') }}" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
          <i class="fas fa-plus me-2"></i>
          kategori
        </a>
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
    <table id="kategori" class="table table-hover align-items-center">
      <thead>
        <tr>
          <th>#</th>
          <th>Nama Kategori</th>
          <th>Hitung Berat</th>
          <th>Hitung Volume</th>
          <th>Tarif per Kg</th>
          <th>Tarif per m³</th>
          <th>Tarif Flat</th>
          <th>Biaya Tambahan</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($kategori as $data)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $data->nama_kategori }}</td>
            <td>
              <span class="badge bg-{{ $data->hitung_berat ? 'success' : 'secondary' }}">
                {{ $data->hitung_berat ? 'Ya' : 'Tidak' }}
              </span>
            </td>
            <td>
              <span class="badge bg-{{ $data->hitung_volume ? 'success' : 'secondary' }}">
                {{ $data->hitung_volume ? 'Ya' : 'Tidak' }}
              </span>
            </td>
            <td>{{ format_rupiah($data->tarif_per_kg ?? 0) }}</td>
            <td>{{ format_rupiah($data->tarif_per_m3 ?? 0) }}</td>
            <td>{{ format_rupiah($data->tarif_flat) ?? 0 }}</td>
            <td>{{ format_rupiah($data->biaya_tambahan) ?? 0 }}</td>
            <td>
              <div class="d-flex gap-2">
                <a href="/kategori/edit/{{ $data->id_kategori }}" class="btn btn-sm btn-warning">
                  <i class="bi bi-pencil-square"></i>
                </a>
                <button class="btn btn-sm btn-danger delete" data-kategorixid="{{ $data->id_kategori }}">
                  <i class="bi bi-trash-fill"></i>
                </button>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="9" class="text-center">Tidak ada data kategori</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  {{ $kategori->links('vendor.pagination.bootstrap-5') }}
  @push('scripts')
    <script>
      $(document).ready(function() {
        const table = $("#kategori tbody tr");
        $("#searchInput").on("keyup", function() {
          const value = $(this).val().toLowerCase();
          table.filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            // menampilkan tidak ada data
          });
        });

        // Gunakan event delegation untuk menangani klik pada tombol deleted permanent
        $(document).on('click', '.delete', function() {
          const kategoriId = $(this).data('kategorixid');

          Swal.fire({
            title: 'Menghapus secara permanen kategori ini?',
            icon: 'warning',
            showCancelButton: true,
            customClass: {
              confirmButton: 'btn btn-danger',
              cancelButton: 'btn btn-gray'
            },
            confirmButtonText: 'Yes, i"m sure!'
          }).then((result) => {
            if (result.isConfirmed) {
              Livewire.emit('deleteKategori', kategoriId);
            }
          });
        });
      });
    </script>
  @endpush
</div>
