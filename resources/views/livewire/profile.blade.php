<div>
  <title>{{ config('app.name') }} | Profile</title>

  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4">
    <div class="d-block mb-4 mb-md-0">
      <h2 class="h4">
      <i class="bi bi-person-fill"></i>
      Profil Information
      </h2>
    </div>
  </div>
  <div class="row mx-2 border-top border-2 pt-4">
    <!-- Form Bagian Kiri -->
    <div class="col-12 col-xl-8">
      <div class="card card-body border-0 shadow mb-4">
        <h2 class="h5 mb-4">Update Profile</h2>
        <form wire:submit.prevent="save" method="POST">
          <div class="row">
            <!-- Nama -->
            <div class="col-md-6 mb-3">
              <label for="first_name">Nama</label>
              <input wire:model="user.nama" id="first_name" type="text" class="form-control"
                placeholder="Masukkan Nama Anda" required>
              @error('user.nama')
                <div class="text-danger mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Username -->
            <div class="col-md-6 mb-3">
              <label for="username">Username</label>
              <input wire:model="user.username" id="username" type="text" class="form-control" disabled>
            </div>
          </div>

          <h2 class="h5 my-4">Change Password</h2>
          <div class="row">
            <!-- Password Lama -->
            <div class="col-md-12 mb-3">
              <label for="old_password">Old Password</label>
              <input wire:model="user.old_password" id="old_password" type="password" class="form-control">
              @error('user.password')
                <div class="text-danger mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Password Baru -->
            <div class="col-md-6 mb-3">
              <label for="new_password">New Password</label>
              <input wire:model="user.password" id="new_password" type="password" class="form-control">
              @error('user.new_password')
                <div class="text-danger mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Konfirmasi Password Baru -->
            <div class="col-md-6 mb-3">
              <label for="confirm_password">Confirm Password</label>
              <input wire:model="user.confirm_password" id="confirm_password" type="password" class="form-control">
              @error('user.confirm_password')
                <div class="text-danger mt-1">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="mt-2">
            <button type="submit" class="btn btn-gray-800 mt-2 animate-up-2">Save All</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Profil Bagian Kanan -->
    <div class="col-12 col-xl-4">
      <div class="row">
        <div class="col-12 mb-4">
          <div class="card shadow border-0 text-center p-0">
            <div wire:ignore.self class="profile-cover rounded-top"
              data-background="{{ asset('assets/img/logo.svg') }}"></div>
            <div class="card-body row justify-content-between">
              <div class="pb-4">
                <img src="{{ asset('storage/img/users/default.jpeg') }}"
                  class="avatar-xl rounded-circle mx-auto mt-n7 mb-3" alt="Profile Photo">
                <h4 class="h3">
                  {{ $user->nama ?? 'User Name' }}
                </h4>
                <h5 class="fw-normal">Administrator {{ config('app.name') }}</h5>
                <p class="text-gray mb-4">Karawang, Indonesia</p>
              </div>
              <small class="fw-semibold mt-4 my-3">
                <span class="text-info">Member since</span>
                <i>{{ auth()->user()->created_at ? auth()->user()->created_at->format('d M Y') : '-' }}</i>
              </small>
            </div>
          </div>
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
</div>
