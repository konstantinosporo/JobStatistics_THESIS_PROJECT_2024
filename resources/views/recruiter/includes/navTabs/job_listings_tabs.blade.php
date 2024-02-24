<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('recruiter.job_listings.view') ? 'active' : '' }}"
      href="{{ route('recruiter.job_listings.view') }}"><i
        class="bi bi-folder-fill text-primary me-2"></i>@lang('messages.recruiter.tab_view')</a>
  </li>
  <li class="nav-item ">
    <a class="nav-link {{ request()->routeIs('job_listings.index') ? 'active' : '' }}"
      href="{{ route('job_listings.index') }} "><i
        class="bi bi-cloud-plus-fill text-primary me-2"></i>@lang('messages.recruiter.tab_create')</a>
  </li>
</ul>
