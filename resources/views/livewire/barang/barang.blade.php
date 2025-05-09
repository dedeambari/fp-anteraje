<div>
    <title>{{ config("app.name")}} - Barang</title>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route("barang")}}">
                            <i class="bi bi-box2-fill" style="font-size: 1.2em"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item active"><a href="{{ route("barang")}}">Barang</a></li>
                </ol>
            </nav>
            <h2 class="h4">List Barang</h2>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route("barang.add")}}" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                <i class="fas fa-plus me-2"></i>
                Add barang
            </a>
            <div class="btn-group ms-2 ms-lg-3">
                {{-- <button type="button" class="btn btn-sm btn-outline-gray-600">Export</button> --}}
                <button class="dropdown-toggle dropdown-toggle-split btn btn-sm btn-outline-gray-600"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Export
                </button>
                <div class="dropdown-menu dropdown-menu-end pb-0">
                    <button class="dropdown-item fw-bold" wire:click="$emit('exportExcel')">Excel</button>
                    <button class="dropdown-item fw-bold rounded-bottom" wire:click="$emit('exportPdf')">Pdf</button>
                </div>
            </div>
        </div>
    </div>
    <div class="table-settings mb-4">
        <div class="row justify-content-between align-items-center">
            <div class="col-9 col-lg-8 d-md-flex">
                <div class="input-group me-2 me-lg-3 fmxw-300">
                    <span class="input-group-text">
                        <svg class="icon icon-xs" x-description="Heroicon name: solid/search"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </span>
                    <input type="text" class="form-control" placeholder="Search barang" id="searchInput">
                </div>
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
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($barang as $data)
                    <tr>
                        <td>{{ $data->nomor_resi }}</td>
                        <td>{{ $data->nama_barang }}</td>
                        <td>{{ $data->pemrosessan->status_proses }}</td>
                        <td>{{ $data->pemrosessan->staf->nama }}</td>
                        <td>{{ format_rupiah($data->total_tarif) ?? 0 }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{route('barang.detail', $data->id)}}" class="btn btn-sm btn-primary btn-circle    ">
                                    <i class="bi bi-eye"></i>
                                </a>
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
    {{ $barang->links("vendor.pagination.bootstrap-5") }}
    @push('scripts')
        <script>
            $(document).ready(function () {
                const table = $("#barang tbody tr");
                $("#searchInput").on("keyup", function () {
                    const value = $(this).val().toLowerCase();
                    table.filter(function () {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                        // menampilkan tidak ada data
                    });
                });

                // Gunakan event delegation untuk menangani klik pada tombol deleted permanent
                $(document).on('click', '.delete', function () {
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
            });
        </script>
    @endpush
</div>