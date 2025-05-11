<div>
    <title>{{ config("app.name")}} - Detail Barang</title>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route("barang")}}">
                            <i class="bi bi-box2-fill" style="font-size: 1.2em"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route("barang")}}">Barang</a></li>
                    <li class="breadcrumb-item active">Detail Barang</a></li>
                </ol>
            </nav>
            <h2 class="h4">Detail Barang</h2>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body d-flex gap-3">
            <button class="btn btn-sm btn-success" wire:click="$emit('editBarang')"><i class="bi bi-pencil-square"></i>
                Edit Semua
            </button>
            <button class="btn btn-sm btn-danger" wire:click="$emit('deleteBarang')"><i class="bi bi-trash-fill"></i>
                Hapus Barang
            </button>
            {{-- cetak --}}
            <div class="btn-group">
                {{-- <button type="button" class="btn btn-sm btn-outline-gray-600">Export</button> --}}
                <button class="dropdown-toggle dropdown-toggle-split btn btn-sm btn-info" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="bi bi-printer-fill"></i> Cetak Barang
                </button>
                <div class="dropdown-menu dropdown-menu-end pb-0">
                    <button class="dropdown-item fw-bold" wire:click="$emit('exportExcel')">
                        <i class="bi bi-filetype-xls"></i> Excel
                    </button>
                    <button class="dropdown-item fw-bold rounded-bottom" wire:click="$emit('exportPdf')">
                        <i class="bi bi-filetype-pdf"></i> Pdf
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        {{-- Detail Barang --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow border-0 table-wrapper table-responsive">
                <div class="card-header bg-info text-white">Info Barang
                    <button class="btn btn-circle btn-outline-gray-600 btn-sm position-absolute end-0 me-2 mt-1 btn-hover" style="top: 12px;"
                        wire:click="$emit('editInfoBarang')">
                        <i class="bi bi-vector-pen text-white"></i>
                    </button>
                </div>
                <table class="table table-hover">
                    <tr>
                        <td>Nomor Resi</td>
                        <td class="w-1 px-0">:</td>
                        <td>{{ $detailBarang->nomor_resi }}</td>
                    </tr>
                    <tr>
                        <td>Nama Barang</td>
                        <td class="w-1 px-0">:</td>
                        <td>{{ $detailBarang->nama_barang }}</td>
                    </tr>
                    <tr>
                        <td>Kategori</td>
                        <td class="w-1 px-0">:</td>
                        <td>{{ $detailBarang->kategori->nama_kategori ?? '-' }}</td>
                    </tr>
                    <!-- Berat Barang -->
                    @if ($detailBarang->kategori && $detailBarang->kategori->hitung_berat)
                        <tr>
                            <td>Berat Barang (kg)</td>
                            <td class="w-1 px-0">:</td>
                            <td>{{ intval($detailBarang->berat) }} Kg</td>
                        </tr>
                    @endif

                    <!-- Volume Barang -->
                    @if ($detailBarang->kategori && $detailBarang->kategori->hitung_volume)
                        <tr>
                            <td>Volume Barang (m<sup>3</sup>)</td>
                            <td class="w-1 px-0">:</td>
                            <td>{{ $detailBarang->volume }} m<sup>3</sup></td>
                        </tr>
                    @endif
                    <tr>
                        <td>Deskripsi Barang</td>
                        <td class="w-1 px-0">:</td>
                        <td>{{ $detailBarang->deskripsi_barang }}</td>
                    </tr>
                    <tr>
                        <td>Total Tarif Harga</td>
                        <td class="w-1 px-0">:</td>
                        <td>{{ format_rupiah($detailBarang->total_tarif) }}</td>
                    </tr>
                </table>
            </div>
        </div>
        {{-- Informasi Pengiriman --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow border-0 table-wrapper table-responsive">
                <div class="card-header bg-secondary text-white">
                    Pengiriman
                    <button class="btn btn-circle btn-outline-gray-600 btn-sm position-absolute end-0 me-2 mt-1 btn-hover" style="top: 12px;"
                        wire:click="$emit('editPengiriman')">
                        <i class="bi bi-vector-pen text-white"></i>
                    </button>
                </div>
                <table class="table table-hover">
                    <tr>
                        <td>Staf Pengirim</td>
                        <td class="w-1 px-0">:</td>
                        <td>{{ $detailBarang->pemrosessan->staf->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Status Proses</td>
                        <td class="w-1 px-0">:</td>
                        <td>{{ $detailBarang->pemrosessan->status_proses ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Proses</td>
                        <td class="w-1 px-0">:</td>
                        <td>{{ date_format($detailBarang->pemrosessan->created_at, 'd/m/Y H:i') ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Estimasi Sampai</td>
                        <td class="w-1 px-0">:</td>
                        <td>{{ date('d/m/Y H:i', strtotime($detailBarang->estimasi_waktu)) ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Catatan Pengiriman</td>
                        <td class="w-1 px-0">:</td>
                        <td>{{ $detailBarang->pengiriman->catatan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Bukti Pengiriman Sampai</td>
                        <td class="w-1 px-0">:</td>
                        <td>{{ $detailBarang->pemrosessan->bukti ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
        {{-- Informasi Pengirim --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow border-0 table-wrapper table-responsive">
                <div class="card-header bg-primary text-white">
                    Informasi Pengirim
                    <button class="btn btn-circle btn-outline-gray-600 btn-sm position-absolute end-0 me-2 mt-1 btn-hover" style="top: 12px;"
                        wire:click="$emit('editInfoPengirim')">
                        <i class="bi bi-vector-pen text-white"></i>
                    </button>
                </div>
                <table class="table table-hover">
                    <tr>
                        <td class="w-25">Nama</td>
                        <td class="w-0 px-0">:</td>
                        <td>{{ $detailBarang->pengirim->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td class="w-1 px-0">:</td>
                        <td>{{ $detailBarang->pengirim->alamat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>No. HP</td>
                        <td class="w-1 px-0">:</td>
                        <td>{{ $detailBarang->pengirim->no_hp ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Informasi Penerima --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow border-0 table-wrapper table-responsive">
                <div class="card-header bg-success text-white">
                    Informasi Penerima
                    <button class="btn btn-circle btn-outline-gray-600 btn-sm position-absolute end-0 me-2 mt-1 btn-hover" style="top: 12px;"
                        wire:click="$emit('editInfoPenerima')">
                        <i class="bi bi-vector-pen text-white"></i>
                    </button>
                </div>
                <table class="table table-hover">
                    <tr>
                        <td class="w-25">Nama</td>
                        <td class="w-1 px-0">:</td>
                        <td>{{ $detailBarang->penerima->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td class="w-1 px-0">:</td>
                        <td>{{ $detailBarang->penerima->alamat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>No. HP</td>
                        <td class="w-1 px-0">:</td>
                        <td>{{ $detailBarang->penerima->no_hp ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Informasi Pembayaran --}}
        <div class="col-12 mb-4">
            <div class="card shadow border-0 table-wrapper table-responsive">
                <div class="card-header bg-warning text-dark">
                    Pembayaran
                    <button class="btn btn-circle btn-outline-gray-600 btn-sm position-absolute end-0 me-2 mt-1 btn-hover" style="top: 12px;"
                        wire:click="$emit('editPembayaran')">
                        <i class="bi bi-vector-pen text-white"></i>
                    </button>
                </div>
                <table class="table table-hover">
                    <tr>
                        <td>Yang Membayar</td>
                        <td class="w-1 px-0">:</td>
                        <td class="text-capitalize">{{ $detailBarang->payment->pays ?? '-' }} Barang</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td class="w-1 px-0">:</td>
                        <td class="text-capitalize">
                            <div
                                class="badge {{ $detailBarang->payment->status == 'sudah_bayar' ? 'bg-success' : 'bg-danger' }}">
                                {{ preg_filter('/[^A-Za-z]/', ' ', $detailBarang->payment->status) ?? '-' }}
                            </div>
                        </td>
                    </tr>
                </table>
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
    <style>
        .card-header .btn-hover {
            display: none;
        }

        .card-header:hover .btn-hover {
            display: inline-block;
        }
    </style>

</div>