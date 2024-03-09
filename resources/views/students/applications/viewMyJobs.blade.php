@extends('layouts.layout')

@section('navbar')
  @include('students.includes.nav.navbarSignedIn')
@endsection

@section('includes')
  @include('includes.colorMode')
@endsection

@section('content')
  <div class="container mt-lg-3">

    @if (auth()->user())
      <h2 class="fw-light my-3">@lang('messages.user_job_listings.job_listings') & @lang('messages.navigation.applications')</h2>
      @include('students.includes.navTabs.applyNavTabs')
    @else
      <p>@lang('messages.user.user_not_available')</p>
      <hr class="border-1 text-danger">
    @endif

    <div class="row justify-content-center mt-3">

      @if ($message)
        <h5>{{ $message }}</h2>
          @foreach ($jobListings as $jobListing)
            <div class="col-md-6 mb-4">
              <div class="card p-3">
                <p><strong>@lang('messages.user_job_listings.job_title')</strong> {{ $jobListing->job_title }}</p>
                <p><strong>@lang('messages.user_job_listings.job_description')</strong> {{ $jobListing->job_description }}</p>
                <p><strong>@lang('messages.user_job_listings.job_location')</strong> {{ $jobListing->location }}</p>
                <p><strong>@lang('messages.user_job_listings.job_qualifications')</strong> {{ $jobListing->qualifications }}</p>

                <!-- Check if the user has already applied for this job listing -->
                @if (optional($jobListing->applicants)->contains(auth()->user()))
                  <p class="text-success">@lang('messages.user_job_listings.already_applied')</p>
                  <!-- Button to unapply -->
                  <form action="{{ route('job_listings.applicant', $jobListing) }}" method="POST">
                    @csrf
                    <div class="d-flex justify-content-end">
                      <button type="submit" class="btn btn-danger">@lang('messages.buttons.unapply')</button>
                    </div>
                  </form>
                @else
                  <!-- If not, show the apply button -->
                  <form action="{{ route('job_listings.applicant', $jobListing) }}" method="POST">
                    @csrf
                    <div class="d-flex justify-content-end">
                      <button type="submit" class="btn btn-primary">@lang('messages.buttons.apply')</button>
                    </div>
                  </form>
                @endif
              </div>
            </div>
          @endforeach
      @endif
    </div>
  </div>
@endsection

@section('footer')
  @include('includes.footer')
@endsection
