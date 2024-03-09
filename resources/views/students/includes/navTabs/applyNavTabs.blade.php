<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('job_listings.applicant_myJobs') ? 'active' : '' }}"
      href="{{ route('job_listings.applicant_myJobs') }}"><i class="bi bi-person-heart mx-2"></i>@lang('messages.user_job_listings.myjobs')</a>
  </li>
  <li class="nav-item ">
    <a class="nav-link {{ request()->routeIs('job_listings.applicant_allJobs') ? 'active' : '' }}"
      href="{{ route('job_listings.applicant_allJobs') }} "><i
        class="bi bi-person-lines-fill mx-2"></i>@lang('messages.user_job_listings.alljobs')</a>
  </li>
</ul>
