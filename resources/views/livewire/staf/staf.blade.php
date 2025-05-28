<div>
  <title>{{ config('app.name') }} - Staf</title>
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4">
    <div class="d-block mb-4 mb-md-0">
      <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
          <li class="breadcrumb-item">
            <a href="{{ route('staf') }}">
              <i class="bi bi-person-badge-fill" style="font-size: 1.2em"></i>
            </a>
          </li>
          <li class="breadcrumb-item active"><a href="{{ route('staf') }}">Staf</a></li>
        </ol>
      </nav>
      <h2 class="h4">List staf</h2>
    </div>
  </div>
  <div class="table-settings mb-4 border-top border-2 pt-4">
    <div class="row g-3 align-items-center justify-content-between">
      {{-- Kiri: Search & Filter --}}
      <div class="col-lg-8">
        <div class="row g-2">
          {{-- Search --}}
          <div class="col-md-3">
            <div class="input-group">
              <span class="input-group-text">
                <svg class="icon icon-xs" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                  aria-hidden="true">
                  <path fill-rule="evenodd"
                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                    clip-rule="evenodd" />
                </svg>
              </span>
              <input type="text" class="form-control" placeholder="Search staf" id="searchInput">
            </div>
          </div>

          {{-- Status Filter --}}
          <div class="col-md-3">
            <select class="form-select" id="statusFilter">
              <option selected>All</option>
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
          </div>

          {{-- date Input --}}
          <div class="col-md-6">
            <div class="input-group">
              <input type="date" class="form-control" id="dateInputFrom">
              <span class="input-group-text">-></span>
              <input type="date" class="form-control" id="dateInputTo">
            </div>
          </div>
        </div>
      </div>

      {{-- Kanan: Export & Add --}}
      <div class="col-lg-2 d-flex justify-content-lg-end align-items-center gap-2">
        <div class="btn-group">
          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown"
            aria-expanded="false">
            Export
          </button>
          <ul class="dropdown-menu">
            <li>
              <a href="{{ route('staf.excel', [
                  'status_deactive_staf' => $status_deactive_staf,
                  'dateFrom' => $dateFrom,
                  'dateTo' => $dateTo,
                  'fileNameExport' => "$fileNameExport.xlsx",
              ]) }}"
                class="dropdown-item fw-bold" target="_blank">
                Excel
              </a>
            </li>
            <li>
              <a href="{{ route('staf.pdf', [
                  'status_deactive_staf' => $status_deactive_staf,
                  'dateFrom' => $dateFrom,
                  'dateTo' => $dateTo,
              ]) }}"
                class="dropdown-item fw-bold" target="_blank">
                PDF
              </a>
            </li>
            <P></P>
          </ul>
        </div>
        <a href="{{ route('staf.add') }}" class="btn btn-gray-800 d-inline-flex align-items-center"
          style="padding: 10px 20px;">
          <i class="fas fa-user-plus"></i>
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
    <table id="staf" class="table user-table table-hover align-items-center">
      <thead>
        <tr>
          <th class="border-bottom">#</th>
          <th class="border-bottom">Nama</th>
          <th class="border-bottom">Username</th>
          <th class="border-bottom">No Handphone</th>
          <th class="border-bottom">Jumlah Tugas</th>
          <th class="border-bottom">Transportasi</th>
          <th class="border-bottom">Waktu</th>
          <th class="border-bottom">Status</th>
          <th class="border-bottom"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($staf as $data)
          <tr>
            <td>
              {{ $loop->iteration }}
            </td>
            <td>
              <div class="d-flex align-items-center">
                <img src='{{ Storage::url($data->profile) }}' class="avatar rounded-circle me-3" alt="Avatar"
                  style="object-fit: cover">
                <div class="d-block text-truncate" style="max-width: 200px;">
                  <span class="fw-bold">{{ $data->nama }}</span>
                </div>
              </div>
            </td>
            <td>
              <span class="fw-bold">{{ $data->username }}</span>
            </td>
            <td>
              <div class="d-block text-truncate" style="max-width: 150px;">
                <span class="fw-bold">{{ $data->no_hp }}</span>
              </div>
            </td>
            <td>
              <span class="fw-bold">{{ $data->qty_task }}</span>
            </td>
            <td>
              <span class="fw-bold text-capitalize">{{ $data->transportasi }}</span>
            </td>
            <td>
              <span class="fw-normal d-flex align-items-center">
                {{ $data->created_at_human }}
              </span>
            </td>
            <td>
              <span class="fw-normal {{ $data->status_deactive_staf === 1 ? 'text-success' : 'text-danger' }}">
                {{ $data->status_deactive_staf === 1 ? 'Active' : 'Inactive' }}
              </span>
            </td>
            <td>
              <div class="d-flex gap-2">
                <a class="btn btn-gray-200 btn-sm d-flex" href="/staf/edit/{{ $data->id }}">
                  <span class="fas fa-user-edit"></span>
                </a>
                @if ($data->status_deactive_staf !== 1)
                  <button class="btn btn-gray-200 btn-sm text-success d-flex active-staf"
                    data-stafvid="{{ $data->id }}">
                    <span class="fas fa-user-check"></span>
                  </button>
                @else
                  <button class="btn btn-gray-200 btn-sm text-warning d-flex deactive-staf"
                    data-stafid="{{ $data->id }}">
                    <span class="fas fa-user-times"></span>
                  </button>
                @endif
                <button class="btn btn-gray-200 btn-sm text-danger d-flex delete-permanent-staf"
                  data-stafxid="{{ $data->id }}">
                  <i class="bi bi-trash-fill"></i>
                </button>
                <button class="btn btn-gray-200 btn-sm text-info d-flex generate-otp" data-bs-toggle="modal"
                  data-stafid="{{ $data->id }}">
                  <i class="bi bi-key-fill"></i>
                </button>
              </div>
            </td>
          </tr>
        @endforeach
        @if ($staf->isEmpty())
          <tr>
            <td colspan="9" class="text-center">Tidak ada data</td>
          </tr>
        @endif

      </tbody>
    </table>
  </div>
  {{ $staf->links('vendor.pagination.bootstrap-5') }}

  <div class="modal fade" id="modal-generate-otp" tabindex="-1" aria-labelledby="OtpLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content shadow">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="OtpLabel">Kode OTP</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
            aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3 text-center">
            <label for="otp" class="form-label fw-semibold" id="otp-label">Kode Otp</label>
            <input type="text" class="form-control text-center fs-4 fw-bold" id="otp" readonly
              style="max-width: 150px; margin: 0 auto;">
            <div class="form-text mt-2 text-muted" id="otp-expired-info">Kode OTP expired dalam 10 menit</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @push('scripts')
    <script>
      $(document).ready(function() {
        const table = $("#staf tbody tr");
        $("#searchInput").on("keyup", function() {
          const value = $(this).val().toLowerCase();
          table.filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            // menampilkan tidak ada data
          });
        });

        $("#statusFilter").on("change", function() {
          const status = this.value;
          Livewire.emit('filterStatus', status);
        });

        // Gunakan event delegation untuk menangani klik pada tombol active
        $(document).on('click', '.active-staf', function() {
          const stafId = $(this).data('stafvid');

          Swal.fire({
            title: 'yakin ingin mengaktifkan staf ini?',
            icon: 'warning',
            showCancelButton: true,
            customClass: {
              confirmButton: 'btn btn-primary',
              cancelButton: 'btn btn-gray'
            },
            confirmButtonText: 'Yes, actived it!'
          }).then((result) => {
            if (result.isConfirmed) {
              Livewire.emit('activedStaf', stafId);
            }
          });
        });

        // Gunakan event delegation untuk menangani klik pada tombol inactive
        $(document).on('click', '.deactive-staf', function() {
          const stafId = $(this).data('stafid');

          Swal.fire({
            title: 'yakin ingin menonaktifkan staf ini?',
            icon: 'warning',
            showCancelButton: true,
            customClass: {
              confirmButton: 'btn btn-primary',
              cancelButton: 'btn btn-gray'
            },
            confirmButtonText: 'Yes, inactive it!'
          }).then((result) => {
            if (result.isConfirmed) {
              Livewire.emit('deactiveStaf', stafId);
            }
          });
        });

        // Gunakan event delegation untuk menangani klik pada tombol deleted permanent
        $(document).on('click', '.delete-permanent-staf', function() {
          const stafId = $(this).data('stafxid');

          Swal.fire({
            title: 'Menghapus secara permanen staf ini?',
            icon: 'warning',
            showCancelButton: true,
            customClass: {
              confirmButton: 'btn btn-danger',
              cancelButton: 'btn btn-gray'
            },
            confirmButtonText: 'Yes, i"m sure!'
          }).then((result) => {
            if (result.isConfirmed) {
              Livewire.emit('deletedStaf', stafId);
            }
          });
        });

        // Gunakan event delegation untuk menangani klik pada tombol generate otp
        $(document).on('click', '.generate-otp', function() {
          const stafId = $(this).data('stafid');
          Livewire.emit('cekStatusOtp', stafId);
        });


        Livewire.on('otpPerluGenerate', (id) => {
          Swal.fire({
            title: 'OTP tidak ditemukan atau sudah expired',
            text: 'Ingin generate OTP baru?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, generate!',
            cancelButtonText: 'Batal',
            customClass: {
              confirmButton: 'btn btn-danger',
              cancelButton: 'btn btn-secondary'
            }
          }).then((result) => {
            if (result.isConfirmed) {
              Livewire.emit('generateResetOtp', id);
            }
          });
        });

        // TIMER
        let otpCountdownTimer = null;
        Livewire.on('valueOtp', (data) => {
          if (!data.isValid || !data.otp) {
            $('#modal-generate-otp').modal('hide');
            const notyf = new Notyf({
              position: {
                x: 'right',
                y: 'top'
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
              message: "OTP sudah tidak berlaku atau sudah digunakan."
            });
            return;
          }

          // CLEAR TIMER
          if (otpCountdownTimer) {
            clearInterval(otpCountdownTimer);
            otpCountdownTimer = null;
          }

          $('#modal-generate-otp').modal('show');
          $('#otp').val(data.otp);
          $('#otp-label').text('Kode OTP ' + data.nama);

          const expiredAt = new Date(data.expired_at);
          const infoElement = document.getElementById('otp-expired-info');

          function updateCountdown() {
            const now = new Date();
            const diffMs = expiredAt - now;

            if (diffMs <= 0) {
              infoElement.innerText = "Kode OTP sudah expired silakan generate ulang.";
              clearInterval(otpCountdownTimer);
              otpCountdownTimer = null;
              return;
            }

            const minutes = Math.floor(diffMs / 60000);
            const seconds = Math.floor((diffMs % 60000) / 1000);

            infoElement.innerText = `Kode OTP expired dalam ${minutes} menit ${seconds} detik`;
          }

          updateCountdown();
          otpCountdownTimer = setInterval(updateCountdown, 1000);
        });


        // Gunakan event delegation untuk menangani klik pada date input
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
