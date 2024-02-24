@php
  $currentRouteName = Route::currentRouteName();
@endphp

<div class="shadow-lg">
  <nav class="navbar navbar-expand-lg" aria-label="Offcanvas navbar large">
    <div class="container ">
      <a class="navbar-brand" href="{{ route('indexStudent') }}"><img src="{{ asset('img/logo.png') }}" alt="logo"
          width="70">
        @lang('messages.misc.jobs_statistics')</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2"
        aria-controls="offcanvasNavbar2" title="Nav Toggler">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
        <div class="offcanvas-header">
          <a class="navbar-brand" href="{{ route('indexStudent') }}"><img src="{{ asset('img/logo.png') }}"
              alt="logo" width="70">@lang('messages.misc.jobs_statistics')</a>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('indexStudent') ? 'active' : '' }}" aria-current="page"
                href="{{ route('indexStudent') }}">@lang('messages.navigation.home')</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs(['statistics', 'graphType1']) ? 'active' : '' }}"
                href="{{ route('statistics') }}">@lang('messages.navigation.statistics')</a>
            </li>
            <li class="nav-item">
              @if (auth()->user()->hasCv())
                <a class="nav-link {{ request()->routeIs('editCv') ? 'active' : '' }}"
                  href="{{ route('editCv') }}">@lang('messages.user.edit_my_cv')</a>
              @else
                <a class="nav-link {{ request()->routeIs('createCv') ? 'active' : '' }}"
                  href="{{ route('createCv') }}">@lang('messages.user.create_my_cv')</a>
              @endif
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('job_listings.applicant_index') ? 'active' : '' }}"
                href="{{ route('job_listings.applicant_index') }}">@lang('messages.navigation.applications')</a>
            </li>


            <!--dropdown starts-->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                @lang('messages.navigation.my_profile')
                <span id="profileBadge"
                  class="position-absolute top-20 start-90 translate-middle p-1 bg-danger border border-light rounded-circle"
                  style="display: none">
                  <!-- Adjusted position with top-10 and start-90 -->
                </span>
              </a>

              <ul class="dropdown-menu text-center  p-1">
                <li><span class="dropdown-item-text">
                    <small>@lang('messages.navigation.student')</small><br> <small class="text-success"><i
                        class="bi bi-person-check me-1"></i>{{ auth()->user()->name }}</small>
                  </span></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <a class="dropdown-item" href="{{ route('messages.index') }}" id="messagesLink"
                  data-clicked="{{ session('messagesClicked', false) }}">
                  <i class="bi bi-envelope me-1"></i>
                  @lang('messages.messages.messages')
                  <span id="unreadMessageBadge" class="badge bg-danger position-relative" style="display: none">
                    <i class="bi bi-chat-text"></i> <!-- Bootstrap Icons chat-text icon -->
                    <span
                      class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger m-0 opacity-75">
                      &nbsp;
                    </span>
                  </span>
                </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="{{ route('signOut') }}"> <i
                  class="bi bi-box-arrow-left me-1"></i>@lang('messages.navigation.sign_out')</a>
            </li>
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

<script>
  window.appData = {
    messagesClicked: {{ session('messagesClicked', false) ? 'true' : 'false' }}
  };
</script>
