<div class="pb-5">
    <title>{{config('app.name')}} - Dashboard</title>
    <div class="py-1">
    </div>
    <div class="row">
        <div class="col-12 col-sm-6 col-xl-3 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div
                            class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-primary rounded me-4 me-sm-0">
                                <i class="fas fa-users fs-2"></i>
                            </div>
                            <div class="d-sm-none">
                                <h2 class="h5">Customers</h2>
                                <h3 class="fw-extrabold mb-1">{{ $totalUser }}</h3>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Customers</h2>
                                <h3 class="fw-extrabold mb-2">{{ $totalUser }} <span class="fs-6">People</span>
                                </h3>
                            </div>
                            <small class="d-flex align-items-center text-gray-500">
                                {{ $tglUserLama }} - {{ $tglUserBaru }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3 mb-4">
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
                                <h3 class="fw-extrabold mb-1">{{ $totalOrders }}</h3>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Barang</h2>
                                <h3 class="fw-extrabold mb-2">{{ $totalOrders }} <span class="fs-6">Barang</span>
                                </h3>
                            </div>
                            <small class="d-flex align-items-center text-gray-500">
                                {{ $tglOrdersLama }} - {{ $tglOrdersBaru }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3 mb-4">
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
                            <small class="d-flex align-items-center text-gray-500">
                                {{ $tglYetPaidLama }} - {{ $tglYetPaidBaru }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3 mb-4">
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
                            <small class="d-flex align-items-center text-gray-500">
                                {{ $tglPaidLama }} - {{ $tglPaidLama }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 mb-4">
            <div class="card border-0 shadow" style="background-color: #ffffffce">
                <div class="card-header d-sm-flex flex-row align-items-center flex-0">
                    <div class="d-block mb-3 mb-sm-0">
                        <div class="fs-5 fw-normal mb-2">Nilai Pesanan</div>
                        <h2 class="fs-3 fw-extrabold">Rp. {{ number_format($totalSales, 0, ',', '.') }}</h2>
                        <div class="small mt-2">
                            <span class="fw-normal me-2">Yesterday</span>
                            <span class="fas fa-angle-up text-success"></span>
                            <span class="text-success fw-bold">{{ number_format($percentageChange, 2) }}%</span>
                        </div>
                    </div>
                    <div class="d-flex ms-auto">
                        <a href="#" class="btn btn-secondary btn-sm me-2">Month</a>
                        <a href="#" class="btn btn-sm me-3">Week</a>
                    </div>
                </div>
                <div class="card-body p-2">
                    <div class="ct-chart-sales-value ct-double-octave ct-series-g"></div>
                </div>
            </div>
        </div>
    </div>
</div>
