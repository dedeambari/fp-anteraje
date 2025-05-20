<main>
  <title>Sign In</title>
  <section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
    <div class="container">
      <div wire:ignore.self class="row justify-content-center form-bg-image"
        data-background-lg="/assets/img/illustrations/signin.svg">
        <div class="col-12 d-flex align-items-center justify-content-center">
          <div class="bg-white shadow-soft border rounded border-light p-4 p-lg-5 w-100 fmxw-500">
            <div class="text-center text-md-center mb-4 mt-md-0">
              <h1 class="mb-3 h3">Sign In </h1>
            </div>
            <form wire:submit.prevent="login" action="#" class="mt-4" method="POST"> <!-- Form -->
              <div class="form-group mb-4"> <label for="username">Your Username</label>
                <div class="input-group">
                  <span class="input-group-text" id="basic-addon1">
                    <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" d="M10 2a4 4 0 100 8 4 4 0 000-8zm-6 14a6 6 0 1112 0H4z"
                        clip-rule="evenodd" />
                    </svg>

                  </span>
                  <input wire:model="username" type="text" class="form-control" placeholder="budi06" id="username"
                    autofocus required>
                </div>
                @error('username')
                  <div wire:key="form" class="invalid-feedback"> {{ $message }} </div>
                @enderror
              </div> <!-- End of Form -->
              <div class="form-group"> <!-- Form -->
                <div class="form-group mb-4"> <label for="password">Your Password</label>
                  <div class="input-group"> <span class="input-group-text" id="basic-addon2">
                      <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                          d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                          clip-rule="evenodd"></path>
                      </svg>
                    </span>
                    <input wire:model.lazy="password" type="password" placeholder="Password" class="form-control"
                      id="password" required>
                  </div>
                  @error('password')
                    <div class="invalid-feedback"> {{ $message }} </div>
                  @enderror
                </div>
                <!-- End of Form -->
                {{-- Remember me  --}}
                <div class="d-flex justify-content-between align-items-top mb-4">
                  <div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="remember" wire:model="remember_me">
                      <label class="form-check-label mb-0" for="remember" >
                        Remember me
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="d-grid"> <button type="submit" class="btn btn-primary">Sign in</button> </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
