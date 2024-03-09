<!-- this is the footer section that appears at the bottom of the page -->
<div class="container footer-container">
  <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">

    <!-- copyright notice for todays year -->
    <p class="col-md-4 mb-0 text-muted">&copy; {{ date('Y') }}|@lang('messages.misc.copyright')</p>


    <!-- conditional block, iff the user is signed in, show a link to their index page; otherwise, show a link to sign in -->

    @php
      $isSignedIn = auth()->check();
      $isAdmin = $isSignedIn ? auth()->user()->isAdmin() : false;
      $isRecruiter = $isSignedIn ? auth()->user()->isRecruiter() : false;
    @endphp

    <a href="{{ $isSignedIn ? ($isAdmin ? route('signedInAdmin') : ($isRecruiter ? route('signedInRecruiter') : route('indexStudent'))) : route('signIn') }}"
      class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
      <!-- Display the logo with a width of 100 pixels -->
      <img src="{{ asset('img/logo.png') }}" alt="logo" width="100">
    </a>

    <!-- Navigation links based on user authentication status and type -->
    <ul class="nav col-md-4 justify-content-end">
      <!-- iff the user is signed in -->
      @if (auth()->check())
        <!-- check if the user is an admin -->
        @if (auth()->user()->isAdmin())
          <!-- display a link to the admin dashboard if the user is an admin -->
          <li class="nav-item"><a href="{{ route('signedInAdmin') }}"
              class="nav-link px-2 text-muted">@lang('messages.admin.admin_panel')</a></li>
          <li class="nav-item"><a href="{{ route('signedInAdmin') }}"
              class="nav-link px-2 text-muted">@lang('messages.admin.edit_jobs')</a>
          </li>
          <li class="nav-item"><a href="{{ route('signedInAdmin') }}"
              class="nav-link px-2 text-muted">@lang('messages.admin.view_users')</a>
          </li>
          <!-- check if the user is a recruiter -->
        @elseif (auth()->user()->isRecruiter())
          <!-- display links for a recruiter, such as Home, Job Listing, and Applicants -->
          <li class="nav-item"><a href="{{ route('signedInAdmin') }}"
              class="nav-link px-2 text-muted">@lang('messages.navigation.home')</a></li>
          <li class="nav-item"><a href="{{ route('signedInAdmin') }}"
              class="nav-link px-2 text-muted">@lang('messages.recruiter.job_listing')</a>
          </li>
          <li class="nav-item"><a href="{{ route('signedInAdmin') }}"
              class="nav-link px-2 text-muted">@lang('messages.recruiter.applicants')</a>
          </li>
          <!-- for other authenticated users (students), show links for Home, Jobs, Statistics, and My CV -->
        @else
          <li class="nav-item"><a href="{{ route('indexStudent') }}"
              class="nav-link px-2 text-muted">@lang('messages.navigation.home')</a></li>

          <li class="nav-item"><a href="{{ route('graphType1') }}"
              class="nav-link px-2 text-muted">@lang('messages.navigation.statistics')</a></li>
          <li class="nav-item">
            <!-- check if the student has a CV; display My CV link if they do, otherwise show Create CV link -->
            @if (auth()->user()->hasCv())
              <a class="nav-link px-2 text-muted" href="{{ route('editCv') }}">@lang('messages.user.edit_my_cv')</a>
            @else
              <a class="nav-link px-2 text-muted" href="{{ route('createCv') }}">@lang('messages.user.create_my_cv')</a>
            @endif
          </li>
          <li class="nav-item"><a href="{{ route('job_listings.applicant_myJobs') }}"
              class="nav-link px-2 text-muted">@lang('messages.navigation.applications')</a></li>
        @endif
        <!-- if the user is not signed in, show links for Home, Sign In, and Sign Up -->
      @else
        <li class="nav-item"><a href="{{ route('index') }}" class="nav-link px-2 text-muted">@lang('messages.navigation.home')</a>
        </li>
        <li class="nav-item"><a href="{{ route('signIn') }}" class="nav-link px-2 text-muted">@lang('messages.buttons.sign_in')</a>
        </li>
        <li class="nav-item"><a href="{{ route('signUp') }}" class="nav-link px-2 text-muted">@lang('messages.buttons.sign_up')</a>
        </li>
      @endif
    </ul>

  </footer>
</div>
