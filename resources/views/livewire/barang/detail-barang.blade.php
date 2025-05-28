<div>
  <title>{{ config('app.name') }} - Detail Barang</title>
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
      <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
          <li class="breadcrumb-item">
            <a href="{{ route('barang') }}">
              <i class="bi bi-box2-fill" style="font-size: 1.2em"></i>
            </a>
          </li>
          <li class="breadcrumb-item"><a href="{{ route('barang') }}">Barang</a></li>
          <li class="breadcrumb-item active">Detail Barang</a></li>
        </ol>
      </nav>
      <h2 class="h4">Detail Barang</h2>
    </div>
  </div>

  <div class="card mb-4">
    <div class="card-body">
      <div class="row">
        <div class="col-md-3 gap-2">
          <a href="{{ route('barang.edit', $detailBarang->nomor_resi) }}"
            class="btn btn-sm btn-success text-white w-100" wire:click="$emit('editBarang')"><i
              class="bi bi-pencil-square"></i>
            Edit Semua
          </a>
        </div>
        <div class="col-md-3 mb-2 my-md-0">
          <button class="btn btn-sm btn-danger w-100" id="delete_barang"><i class="bi bi-trash-fill"></i>
            Hapus Barang
          </button>
        </div>
        <div class="col-md-3 mb-2 my-md-0">
          {{-- cetak --}}
          <div class="btn-group w-100">
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

        <div class="col-md-3">
          <a href="{{ route('barang.detail.struk.pdf', $detailBarang->id) }}" target="_blank"
            class="btn btn-sm btn-outline-primary w-100">
            <i class="bi bi-printer"></i> Cetak Struk
          </a>

        </div>
      </div>
    </div>
  </div>

  <div class="row">
    {{-- Detail Barang --}}
    <div class="col-md-6 mb-4">
      <div class="card shadow border-0 table-wrapper table-responsive bg-info">
        <div class="card-header w-100 text-white">Info Barang
          <button class="btn btn-circle btn-outline-gray-600 btn-sm position-absolute end-0 me-2 mt-1 btn-hover"
            style="top: 12px;" onclick="showModal('info-barang')">
            <i class="bi bi-vector-pen text-white"></i>
          </button>
        </div>
        <table class="table table-hover table-light">
          <tr>
            <td>Nomor Resi</td>
            <td class="w-1 px-0">:</td>
            <td class="flex">
              <span id="nomorResi">{{ $detailBarang->nomor_resi }}</span>
              <span id="copyResiBtn" class="ml-2 text-info" style="cursor: pointer">
                <i class="bi bi-clipboard"></i>
              </span>
            </td>
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
          @elseif ($detailBarang->kategori && $detailBarang->kategori->hitung_volume)
            <tr>
              <td>Volume Barang (m<sup>3</sup>)</td>
              <td class="w-1 px-0">:</td>
              <td>{{ number_format($detailBarang->volume, 0) }} m<sup>3</sup></td>
            </tr>
          @else
            <tr>
              <td>Tarif Flat </td>
              <td class="w-1 px-0">:</td>
              <td>{{ format_rupiah($detailBarang->kategori->tarif_flat) }} </td>
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
            <td>
              {{ format_rupiah($detailBarang->total_tarif) }}
              {{ $detailBarang->kategori->biaya_tambahan > 0 ? ' + (' . format_rupiah($detailBarang->kategori->biaya_tambahan) . ')' : '' }}
            </td>
          </tr>
        </table>
      </div>
    </div>
    {{-- Informasi Pengiriman --}}
    <div class="col-md-6 mb-4">
      <div class="card shadow border-0 table-wrapper table-responsive bg-secondary">
        <div class="card-header w-100 text-white">
          Pengiriman
          <button class="btn btn-circle btn-outline-gray-600 btn-sm position-absolute end-0 me-2 mt-1 btn-hover"
            style="top: 12px;" onclick="showModal('pengiriman')">
            <i class="bi bi-vector-pen text-white"></i>
          </button>
        </div>
        <table class="table table-hover table-light">
          <tr>
            <td>Staf Pengirim</td>
            <td class="w-1 px-0">:</td>
            <td>{{ $detailBarang->pemrosessan->staf->nama ?? '-' }}</td>
          </tr>
          <tr>
            <td>Status Proses</td>
            <td class="w-1 px-0">:</td>
            <td>
              {{ $detailBarang->pemrosessan->status_proses ?? '-' }}
              <a href="#" data-bs-toggle="modal" class="text-info ms-2" style="text-decoration: underline;"
                data-bs-target="#progress-{{ $detailBarang->id }}">
                <i class="bi bi-info-circle"></i>
              </a>
              <!-- Modal -->
              <div class="modal fade" id="progress-{{ $detailBarang->id }}" tabindex="-1"
                aria-labelledby="progressLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="progressLabel">Progress Pemrosesan</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                      <div class="border-start border-2 border-primary ps-3">
                        @foreach ($histroyPrgoress as $progres)
                          <div class="d-flex mb-4 align-items-center border-bottom pb-1">
                            <!-- Icon atau titik status -->
                            <div
                              class="{{ $progres->status_proses === 'diproses'
                                  ? 'bg-secondary'
                                  : ($progres->status_proses === 'diantar'
                                      ? 'bg-primary'
                                      : 'bg-success') }} rounded-circle me-3 shadow"
                              style="width: 15px; height: 15px; margin-bottom: 6px;"></div>

                            <!-- Konten status -->
                            <div>
                              <p class="mb-1 fw-bold text-capitalize">
                                {{ $progres->status_proses }}
                              </p>
                              <p class="mb-0 text-muted small">
                                {{ $progres->updated_at->format('d M Y H:i') }}
                              </p>
                            </div>
                          </div>
                        @endforeach
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>Update Proses</td>
            <td class="w-1 px-0">:</td>
            <td>{{ date_format($detailBarang->pemrosessan->updated_at, 'd/m/Y H:i') ?? '-' }}</td>
          </tr>
          <tr>
            <td>Estimasi Sampai</td>
            <td class="w-1 px-0">:</td>
            <td>{{ date('d/m/Y H:i', strtotime($detailBarang->pemrosessan->estimasi_waktu)) ?? '-' }}</td>
          </tr>
          <tr>
            <td>Catatan Pengiriman</td>
            <td class="w-1 px-0">:</td>
            @php
              $catatan = $detailBarang->pemrosessan->catatan ?? '-';
              $panjangMaks = 20;
            @endphp

            <td>
              @if (strlen($catatan) > $panjangMaks)
                <span>{{ Str::limit($catatan, $panjangMaks) }}</span>
                <a href="#" data-bs-toggle="modal" class="text-info" style="text-decoration: underline;"
                  data-bs-target="#catatanModal-{{ $detailBarang->id }}">
                  more
                </a>

                <!-- Modal -->
                <div class="modal fade" id="catatanModal-{{ $detailBarang->id }}" tabindex="-1"
                  aria-labelledby="catatanModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="catatanModalLabel">Catatan Lengkap</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                          aria-label="Tutup"></button>
                      </div>
                      <div class="modal-body">
                        <p class="text-wrap">
                          {{ $catatan }}
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              @else
                {{ $catatan }}
              @endif
            </td>

          </tr>
          <tr>
            <td>Bukti Pengiriman Sampai</td>
            <td class="w-1 px-0">:</td>
            <td>
              @if ($detailBarang->pemrosessan->bukti)
                <a href="{{ route('barang.bukti', $detailBarang->nomor_resi) }}" target="_blank">
                  <i class="bi bi-file-earmark-image"></i> Lihat Bukti
                </a>
              @else
                -
              @endif
            </td>
          </tr>
        </table>
      </div>
    </div>
    {{-- Informasi Pengirim --}}
    <div class="col-md-6 mb-4">
      <div class="card shadow border-0 table-wrapper table-responsive bg-primary">
        <div class="card-header w-100 text-white">
          Informasi Pengirim
          <button class="btn btn-circle btn-outline-gray-600 btn-sm position-absolute end-0 me-2 mt-1 btn-hover"
            style="top: 12px;" onclick="showModal('pengirim')">
            <i class="bi bi-vector-pen text-white"></i>
          </button>
        </div>
        <table class="table table-hover table-light">
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
      <div class="card shadow border-0 table-wrapper table-responsive bg-success">
        <div class="card-header w-100 text-white">
          Informasi Penerima
          <button class="btn btn-circle btn-outline-gray-600 btn-sm position-absolute end-0 me-2 mt-1 btn-hover"
            style="top: 12px;" onclick="showModal('penerima')">
            <i class="bi bi-vector-pen text-white"></i>
          </button>
        </div>
        <table class="table table-hover table-light">
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
      <div class="card shadow border-0 table-wrapper table-responsive bg-warning">
        <div class="card-header w-100 text-dark">
          Pembayaran
          <button class="btn btn-circle btn-outline-gray-600 btn-sm position-absolute end-0 me-2 mt-1 btn-hover"
            style="top: 12px;" onclick="showModal('pembayaran')">
            <i class="bi bi-vector-pen text-white"></i>
          </button>
        </div>
        <table class="table table-hover table-light">
          <tr>
            <td>Yang Membayar</td>
            <td class="w-1 px-0">:</td>
            <td class="text-capitalize">{{ $detailBarang->payment->pays ?? '-' }} Barang</td>
          </tr>
          <tr>
            <td>Status</td>
            <td class="w-1 px-0">:</td>
            <td class="text-capitalize">
              <div class="badge {{ $detailBarang->payment->status == 'sudah_bayar' ? 'bg-success' : 'bg-danger' }}">
                {{ preg_filter('/[^A-Za-z]/', ' ', $detailBarang->payment->status) ?? '-' }}
              </div>
            </td>
          </tr>
        </table>
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
      .card-header w-100 .btn-hover {
        display: none;
      }

      .card-header w-100:hover .btn-hover {
        display: inline-block;
      }
    </style>

    @include('livewire.barang.modal.modal-edit')
    @push('scripts')
      <script>
        function showModal($typeEdit) {
          Livewire.emit('showModal', $typeEdit);
          $('#editModal').modal('show')
        }

        $(document).ready(function() {
          Livewire.on('closeModal', () => {
            $('#editModal').modal('hide')
          })
        })
      </script>
    @endpush

  </div>

  @push('scripts')
    <script>
      $(document).ready(function() {
        $(document).on('click', '#delete_barang', function() {
          Swal.fire({
            title: 'Ingin Menghapus Barang ini?',
            icon: 'warning',
            showCancelButton: true,
            customClass: {
              confirmButton: 'btn btn-danger',
              cancelButton: 'btn btn-gray'
            },
            confirmButtonText: 'Yes, i"m sure!'
          }).then((result) => {
            if (result.isConfirmed) {
              Livewire.emit('deleteBarang');
            }
          });
        });
      })
      $('#copyResiBtn').click(function() {
        var resi = $('#nomorResi').text();
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

        // Buat elemen input sementara untuk copy
        var $temp = $('<input>');
        $('body').append($temp);
        $temp.val(resi).select();

        try {
          var successful = document.execCommand('copy');
          if (successful) {
            notyf.open({
              type: 'success',
              message: 'Nomor resi berhasil disalin.'
            });
          } else {
            notyf.open({
              type: 'error',
              message: 'Nomor resi gagal disalin.'
            });
          }
        } catch (err) {
          notyf.open({
            type: 'error',
            message: 'Nomor resi gagal disalin.'
          });
        }

        $temp.remove();
      });
    </script>
  @endpush
</div>
