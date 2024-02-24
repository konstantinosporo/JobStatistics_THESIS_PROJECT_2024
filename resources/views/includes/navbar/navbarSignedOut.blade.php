<div class="shadow">
  <nav class="navbar navbar-expand-lg" aria-label="Offcanvas navbar large">
    <div class="container">
      <a class="navbar-brand" href="{{ route('index') }}">
        <img src="{{ asset('img/logo.png') }}" alt="logo" width="60" height="50">
        @lang('messages.misc.jobs_statistics')
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2"
        aria-controls="offcanvasNavbar2" title="Nav Toggler">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
        <div class="offcanvas-header">
          <a class="navbar-brand" href="{{ route('index') }}">
            <img src="{{ asset('img/logo.png') }}" alt="logo" width="70">
            @lang('messages.misc.jobs_statistics')
          </a>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('index') ? 'active' : '' }}" aria-current="page"
                href="{{ route('index') }}">
                @lang('messages.navigation.home')
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('signIn') ? 'active' : '' }}" href="{{ route('signIn') }}">
                @lang('messages.buttons.sign_in')
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                @lang('messages.misc.more')
              </a>
              <ul class="dropdown-menu text-center text-hover">
                <li><a class="dropdown-item" href="{{ route('signUp') }}">
                    <i class="bi bi-door-open me-1"></i>
                    @lang('messages.buttons.sign_up')
                  </a>
                </li>
                <li><a class="dropdown-item" href="#">
                    <i class="bi bi-info-square me-1"></i> @lang('messages.misc.about_us')
                  </a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li class=" btn-group d-flex justify-content-around">
                  <x-form-button :action="route('switch.language', ['locale' => 'en'])" method="GET"
                    class="btn btn-outline-danger rounded-circle border-0 p-1 ">
                    <img src="{{ asset('img/lang/england.png') }}" alt="English"
                      style="width: 25px; height: 25px; border-radius: 50%;">
                  </x-form-button>
                  <x-form-button :action="route('switch.language', ['locale' => 'el'])" method="GET"
                    class="btn btn-outline-primary rounded-circle border-0 p-1">
                    <img src="{{ asset('img/lang/greece.png') }}" alt="Greek"
                      style="width: 27px; height: 22px; border-radius: 50%;">
                  </x-form-button>
                </li>
              </ul>
            </li>
          </ul>

        </div>
      </div>
    </div>
  </nav>
</div>
