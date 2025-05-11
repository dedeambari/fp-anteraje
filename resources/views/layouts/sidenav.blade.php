<nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
    <div class="sidebar-inner px-2 pt-3">
        <ul class="nav flex-column pt-3 pt-md-0 gap-2">
            <li class="nav-item py-0">
                <a href="/dashboard" class="nav-link py-0 d-flex mx-5">
                    <span class="sidebar-icon">
                        <img src="/assets/img/logo.svg" alt="Volt Logo" style="object-fit: cover; width:30px;">
                    </span>
                    <span class="mt-1 sidebar-text" style="font-weight: 600;">
                        {{ config('app.name') . ' ' . config('app.version') }}
                    </span>

                </a>
            </li>
            {{-- sparator --}}
            <li role="separator" class="dropdown-divider my-1 border-gray-500"></li>
            {{-- Dashboard --}}
            <li class="nav-item menu-side {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}">
                <a href="/dashboard" class="nav-link">
                    <span class="sidebar-icon">
                        <i class="bi bi-house-fill"></i></span></span>
                    <span class="sidebar-text">Dashboard</span>
                </a>
            </li>

            {{-- Staf --}}
            <li class="nav-item menu-side {{ Request::segment(1) == 'staf' ? 'active' : '' }}">
                <a href="{{ route("staf")}}" class="nav-link">
                    <span class="sidebar-icon">
                        <i class="bi bi-person-badge-fill" style="font-size: 1.2em"></i></span></span>
                    </span>
                    <span class="sidebar-text">Staf</span>
                </a>
            </li>

            {{-- Kategori --}}
            <li class="nav-item menu-side {{ Request::segment(1) == 'kategori' ? 'active' : '' }}">
                <a href="{{ route("kategori")}}" class="nav-link">
                    <span class="sidebar-icon">
                        <i class="bi bi-card-list" style="font-size: 1.2em"></i></span></span>
                    </span>
                    <span class="sidebar-text">Kategori</span>
                </a>
            </li>

            {{-- Barang Kiriman --}}
            <li class="nav-item menu-side {{ Request::segment(1) == 'barang' ? 'active' : '' }}">
                <a href="/barang" class="nav-link">
                    <span class="sidebar-icon">
                        <i class="bi bi-box2-fill" style="font-size: 1.2em"></i></span></span>
                    </span>
                    <span class="sidebar-text">Barang</span>
                </a>
            </li>

            {{-- Barang Per Kategori --}}
            <li class="nav-item menu-side">
                <span class="nav-link collapsed d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" data-bs-target="#submenu-laravel" aria-expanded="true">
                    <span>
                        <span class="sidebar-text" style="color: #e4e4e7;">Kategori Barang</span>
                    </span>
                    <span class="link-arrow">
                        <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </span>
                </span>
                <div class="multi-level collapse show" role="list" id="submenu-laravel" aria-expanded="false">
                    <ul class="flex-column nav">
                        <li class="nav-item menu-side {{ Request::segment(2) == 'all' ? 'active' : '' }}">
                            <a href="/kategori/all" class="nav-link" wire:navigate>
                                <span class="sidebar-text">Semua Kategori</span>
                            </a>
                        </li>
                        @foreach (\App\Models\KategoriBarang::all() as $kategori)
                            <li class="nav-item menu-side {{ request()->is("kategori/$kategori->id") ? 'active' : '' }}">
                                <a href="/kategori/{{ $kategori->id_kategori }}" class="nav-link">
                                    <span class="sidebar-text">{{ $kategori->nama_kategori }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>

            {{-- Transaksi --}}
            <li class="nav-item menu-side">
                <span class="nav-link collapsed d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" data-bs-target="#submenu-pembayaran" aria-expanded="true">
                    <span>
                        <span class="sidebar-text" style="color: #e4e4e7;">Pembayaran</span>
                    </span>
                    <span class="link-arrow">
                        <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </span>
                </span>
                <div class="multi-level collapse show" role="list" id="submenu-pembayaran" aria-expanded="false">
                    <ul class="flex-column nav">
                        <li class="nav-item {{ Request::segment(2) == 'sudah-bayar' ? 'active' : '' }}">
                            <a href="/pembayaran/sudah-bayar" class="nav-link">
                                <span class="sidebar-text">Sudah Bayar</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::segment(2) == 'belum-bayar' ? 'active' : '' }}">
                            <a href="/pembayaran/belum-bayar" class="nav-link">
                                <span class="sidebar-text">Belum Bayar</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

        </ul>


        <div
            class="d-flex justify-content-center flex-wrap flex-md-nowrap align-items-center h-100 w-100 position-relative">
            <button class="navbar-toggler d-md-none collapsed bg-white" type="button" data-bs-toggle="collapse"
                data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                aria-label="Toggle navigation"
                style="border-radius: 50%; width: 40px; height: 40px; border-color: #e4e4e7;">
                >
                <span class="navbar-toggler-icon">
                </span>
            </button>
        </div>
    </div>
</nav>