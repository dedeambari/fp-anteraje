<nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
  <div class="sidebar-inner px-2 pt-3 d-flex flex-column justify-content-between">
    <ul class="nav flex-column pt-3 pt-md-0 gap-2">
      <li class="nav-item py-0">
        <a href="/dashboard" class="nav-link py-0">
          <span class="sidebar-icon">
            <img src="/assets/img/logo.svg" alt="Volt Logo" style="object-fit: cover; width:40px;">
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
            <span class="fas fa-tachometer-alt" style="font-size: 1.1em"></span>
          </span>
          <span class="sidebar-text">Dashboard</span>
        </a>
      </li>

      {{-- Staf --}}
      <li class="nav-item menu-side {{ Request::segment(1) == 'staf' ? 'active' : '' }}">
        <a href="{{ route('staf') }}" class="nav-link">
          <span class="sidebar-icon">
            <i class="bi bi-person-badge-fill" style="font-size: 1.2em"></i></span></span>
          </span>
          <span class="sidebar-text">Staf</span>
        </a>
      </li>

      {{-- Kategori --}}
      <li class="nav-item menu-side {{ Request::segment(1) == 'kategori' ? 'active' : '' }}">
        <a href="{{ route('kategori') }}" class="nav-link">
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
            <i class="bi bi-box2-fill" style="font-size: 1.1em"></i></span></span>
          </span>
          <span class="sidebar-text">Barang</span>
        </a>
      </li>

    </ul>
    <div
      class="d-flex justify-content-center flex-wrap flex-md-nowrap align-items-center h-100 w-100 position-relative">
      <button class="navbar-toggler d-md-none collapsed bg-white" type="button" data-bs-toggle="collapse"
        data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation"
        style="border-radius: 50%; width: 40px; height: 40px; border-color: #e4e4e7;">
        >
        <span class="navbar-toggler-icon">
        </span>
      </button>
    </div>
    {{-- Sidebar Footer: Profil Pengguna --}}
    <ul class="nav flex-column pb-3  pt-2 gap-2 d-none d-lg-block border-top">
      <li class="nav-item dropdown ms-lg-3 d-flex justify-content-between">
        <div class="pt-1 px-0">
          <div class="media d-flex align-items-center">
            <div class="media-body align-items-center d-flex gap-2">
              <img draggable="false" class="avatar rounded-circle" alt="Image placeholder"
                src="{{ asset('storage/img/users/default.jpeg') }}" style="object-fit: cover">
              <span class="mb-0 font-small fw-bold text-light" aria-label="User Name">
                {{ auth()->user()->nama ? auth()->user()->nama : 'User Name' }}
              </span>
            </div>
          </div>
        </div>
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button">
          <span class="fas fa-ellipsis-v"></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end py-1">
          <li>
            <a class="dropdown-item text-dark" href="{{ route('profile') }}">
              <i class="bi bi-person-fill-gear me-2 text-primary" style="font-size: 1.3em;"></i>Profil
            </a>
          </li>
          <li><a class="dropdown-item text-dark">
              <livewire:logout />
            </a></li>
        </ul>
      </li>
    </ul>
  </div>

</nav>
