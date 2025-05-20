<nav class="navbar navbar-dark navbar-theme-primary px-4 col-12 d-md-none position-relative">
    <div class="d-flex align-items-center justify-content-between w-100">
        <button class="navbar-toggler d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="navbar-nav align-items-center">
            <li class="nav-item dropdown ms-lg-3">
                <a class="nav-link dropdown-toggle pt-1 px-0" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <div class="media d-flex align-items-center">
                        <div class="media-body me-2 text-dark align-items-center">
                            <span class="mb-0 font-small fw-bold text-light">
                                {{ auth()->user()->nama ? auth()->user()->nama : 'User Name' }}
                            </span>
                        </div>
                        <img class="avatar rounded-circle" alt="Image placeholder"
                            src="{{ asset('storage/img/users/default.jpeg') }}" style="object-fit: cover">
                    </div>
                </a>
                <div class="dropdown-menu dashboard-dropdown dropdown-menu-end mt-2 py-1 position-absolute end-0">
                    <a class="dropdown-item d-flex align-items-center">
                        <livewire:logout />
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>