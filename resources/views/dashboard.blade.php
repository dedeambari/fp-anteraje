<div class="pt-4">
  <title>{{ config('app.name') }} - Dashboard</title>
  <div class="py-1">
  </div>
  <div class="row">
    {{-- Total Staf --}}
    <a href="{{ route('staf') }}" class="col-12 col-sm-6 col-xl-3 mb-4">
      <div class="card border-0 shadow">
        <div class="card-body">
          <div class="row d-block d-xl-flex align-items-center">
            <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
              <div class="icon-shape icon-shape-primary rounded me-4 me-sm-0">
                <i class="fas fa-users fs-2"></i>
              </div>
              <div class="d-sm-none">
                <h2 class="h5">Staf</h2>
                <h3 class="fw-extrabold mb-1">{{ $totalUser }}</h3>
              </div>
            </div>
            <div class="col-12 col-xl-7 px-xl-0">
              <div class="d-none d-sm-block">
                <h2 class="h6 text-gray-400 mb-0">Staf Antar</h2>
                <h3 class="fw-extrabold mb-2">{{ $totalUser }} <span class="fs-6">Staf</span>
                </h3>
              </div>
              <small class="d-flex align-items-center text-gray-500" style="font-size: 12px;">
                {{ $tglUserLama }} - {{ $tglUserBaru }}
              </small>
            </div>
          </div>
        </div>
      </div>
    </a>
    {{-- Total Barang --}}
    <a href="{{ route('barang') }}" class="col-12 col-sm-6 col-xl-3 mb-4">
      <div class="card border-0 shadow">
        <div class="card-body">
          <div class="row d-block d-xl-flex align-items-center">
            <div
              class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
              <div class="icon-shape icon-shape-secondary rounded me-4 me-sm-0">
                <i class="fas fa-box fs-2"></i>
              </div>
              <div class="d-sm-none">
                <h2 class="h5">Barang</h2>
                <h3 class="fw-extrabold mb-1">{{ $totalBarang }}</h3>
              </div>
            </div>
            <div class="col-12 col-xl-7 px-xl-0">
              <div class="d-none d-sm-block">
                <h2 class="h6 text-gray-400 mb-0">Barang</h2>
                <h3 class="fw-extrabold mb-2">{{ $totalBarang }} <span class="fs-6">Barang</span>
                </h3>
              </div>
              <small class="d-flex align-items-center text-gray-500" style="font-size: 12px;">
                {{ $tglOrdersLama }} - {{ $tglOrdersBaru }}
              </small>
            </div>
          </div>
        </div>
      </div>
    </a>
    {{-- Total Pembayaran --}}
    {{-- Total Pembayaran Belum Lunas --}}
    <a href="{{ route('barang') }}" class="col-12 col-sm-6 col-xl-3 mb-4">
      <div class="card border-0 shadow">
        <div class="card-body">
          <div class="row d-block d-xl-flex align-items-center">
            <div
              class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
              <div class="icon-shape icon-shape-danger rounded me-4 me-sm-0">
                <i class="bi bi-wallet2 fs-2"></i>
              </div>
              <div class="d-sm-none">
                <h2 class="h5">Payments</h2>
                <h3 class="fw-extrabold mb-1">{{ $totalYetPaid }}</h3>
              </div>
            </div>
            <div class="col-12 col-xl-7 px-xl-0">
              <div class="d-none d-sm-block">
                <h2 class="h6 text-gray-400 mb-0">Payments</h2>
                <h3 class="fw-extrabold mb-2">{{ $totalYetPaid }} <span class="fs-6">Unpaid</span>
                </h3>
              </div>
              <small class="d-flex align-items-center text-gray-500" style="font-size: 12px;">
                {{ $tglYetPaidLama }} - {{ $tglYetPaidBaru }}
              </small>
            </div>
          </div>
        </div>
      </div>
    </a>
    {{-- Total Pembayaran Lunas --}}
    <a href="{{ route('barang') }}" class="col-12 col-sm-6 col-xl-3 mb-4">
      <div class="card border-0 shadow">
        <div class="card-body">
          <div class="row d-block d-xl-flex align-items-center">
            <div
              class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
              <div class="icon-shape icon-shape-success rounded me-4 me-sm-0">
                <i class="bi bi-wallet-fill fs-2"></i>
              </div>
              <div class="d-sm-none">
                <h2 class="h5">Payments</h2>
                <h3 class="fw-extrabold mb-1">{{ $totalPaid }}</h3>
              </div>
            </div>
            <div class="col-12 col-xl-7 px-xl-0">
              <div class="d-none d-sm-block">
                <h2 class="h6 text-gray-400 mb-0">Payments</h2>
                <h3 class="fw-extrabold mb-2">{{ $totalPaid }} <span class="fs-6">Paid</span>
                </h3>
              </div>
              <small class="d-flex align-items-center text-gray-500" style="font-size: 12px;">
                {{ $tglPaidLama }} - {{ $tglPaidLama }}
              </small>
            </div>
          </div>
        </div>
      </div>
    </a>


    <div class="col-12 mb-4">
      <div class="card border-0 shadow" style="background-color: #ffffffce">
        <div class="card-header d-sm-flex flex-row align-items-center flex-0">
          <div class="d-block mb-3 mb-sm-0">
            <div class="fs-5 fw-normal mb-2">Nilai Pesanan</div>
            <h2 class="fs-3 fw-extrabold">{{ $totalSales }}</h2>
            <div class="small mt-2">
              <span class="fw-normal me-2">Yesterday</span>

              <!-- Icon arah naik/turun -->
              @if ($percentageChange > 0)
                <span class="fas fa-angle-up text-success"></span>
              @else
                <span class="fas fa-angle-down text-danger"></span>
              @endif

              <!-- Warna teks berdasarkan nilai -->
              <span class="{{ $percentageChange > 0 ? 'text-success' : 'text-danger' }} fw-bold">
                {{ $percentageChange }}%
              </span>
            </div>

          </div>
          <div class="d-flex ms-auto">
            <a href="#" class="btn btn-sm me-2" id="btn-month" data-type="month">Month</a>
            <a href="#" class="btn btn-sm me-3" id="btn-week" data-type="week">Week</a>
          </div>

        </div>
        <div class="card-body ">
          <div id="sales-chart" class="ct-chart-sales-value ct-double-octave ct-series-g"></div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
  <script>
    $(document).ready(function() {
      // Data dari Laravel
      let monthData = {!! json_encode($monthData) !!};
      let weekData = {!! json_encode($weekData) !!};

      function renderChart(data) {
        const labels = data.map(item => item.date);
        const series = data.map(item => item.total_tarif);

        new Chartist.Line('.ct-chart-sales-value', {
          labels: labels,
          series: [series]
        }, {
          low: 0,
          showArea: true,
          fullWidth: true,
          chartPadding: {
            right: 40,
            left: 40,
            bottom: 10
          },
          lineSmooth: Chartist.Interpolation.simple({
            divisor: 2
          }),
          plugins: [
            Chartist.plugins.tooltip()
          ],
          axisX: {
            showGrid: true
          },
          axisY: {
            showGrid: true
          }
        });
      }

      // Default render (month)
      renderChart(weekData);

      // Aktifkan tombol default
      $('#btn-week').addClass('btn-secondary').removeClass('btn-outline-secondary');
      $('#btn-month').removeClass('btn-secondary').addClass('btn-outline-secondary');

      // Toggle event
      $('#btn-month').on('click', function(e) {
        e.preventDefault();
        renderChart(monthData);
        $(this).addClass('btn-secondary').removeClass('btn-outline-secondary');
        $('#btn-week').removeClass('btn-secondary').addClass('btn-outline-secondary');
      });

      $('#btn-week').on('click', function(e) {
        e.preventDefault();
        renderChart(weekData);
        $(this).addClass('btn-secondary').removeClass('btn-outline-secondary');
        $('#btn-month').removeClass('btn-secondary').addClass('btn-outline-secondary');
      });
    });
  </script>
@endpush
