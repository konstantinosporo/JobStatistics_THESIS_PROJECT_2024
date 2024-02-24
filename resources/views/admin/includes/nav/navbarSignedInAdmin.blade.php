@php
    $currentRouteName = Route::currentRouteName();
    $newMessagesCount = isset($messageCount) ? $messageCount : 0;
@endphp


<div class="shadow-lg">
    <nav class="navbar navbar-expand-lg " aria-label="Offcanvas navbar large">
        <div class="container">
            <a class="navbar-brand" href="{{ route('signedInAdmin') }}"><img src="{{ asset('img/logo.png') }}"
                    alt="logo">@lang('messages.misc.jobs_statistics')</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2"
                aria-controls="offcanvasNavbar2" title="Nav Toggler">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar2"
                aria-labelledby="offcanvasNavbar2Label">
                <div class="offcanvas-header">
                    <a class="navbar-brand" href="{{ route('signedInAdmin') }}"><img src="{{ asset('img/logo.png') }}"
                            alt="logo" width="70">@lang('messages.misc.jobs_statistics')</a>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('signedInAdmin') ? 'active' : '' }}"
                                aria-current="page" href="{{ route('signedInAdmin') }}">@lang('messages.admin.admin_panel')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.jobs.indexDescriptions') ? 'active' : '' }}"
                                href="{{ route('admin.jobs.indexDescriptions') }}">@lang('messages.admin.edit_jobs')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.viewUsers.indexViewUsers') ? 'active' : '' }}"
                                href="{{ route('admin.viewUsers.indexViewUsers') }}">@lang('messages.admin.view_users')</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                @lang('messages.navigation.my_profile')
                            </a>
                            <ul class="dropdown-menu text-center text-hover p-1">
                                <li><span class="dropdown-item-text">
                                        <small>@lang('messages.admin.admin'):</small><br> <small class="text-success"><i
                                                class="bi bi-person-check me-1"></i>{{ auth()->user()->name }}</small>
                                    </span></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                <li><a class="dropdown-item {{ request()->routeIs('my.posts') ? 'active' : '' }}"
                                        href="#"><i class="bi bi-gear me-1"></i>@lang('messages.recruiter.settings')</a>
                                </li>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li class="text-center text-hover"><a class="dropdown-item"
                                        href="{{ route('signOut') }}"><i
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
