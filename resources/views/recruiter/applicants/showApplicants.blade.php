<!-- resources/views/job_listings/applicants.blade.php -->

@extends('layouts.layout')

@section('navbar')
  @include('recruiter.includes.nav.navbarSignedInRecruiter')
@endsection

@section('includes')
  @include('includes.colorMode')
@endsection

@section('content')
  <div class="container">
    <h2 class="my-5">@lang('messages.recruiter_view_applicants.jobs_and_applicants')</h2>

    @if (count($jobListings) > 1)
      <select id="jobListingsDropdown">
        @foreach ($jobListings as $jobListing)
          <option value="{{ $jobListing->id }}">{{ $jobListing->job_title }}</option>
        @endforeach
      </select>

      @foreach ($jobListings as $jobListing)
        <div class="applicants-container" id="applicantsContainer{{ $jobListing->id }}" style="display: none;">
          <h3> @lang('messages.recruiter.applicants'): {{ $jobListing->job_title }}</h3>
          <ul>
            @foreach ($jobListing->applicants as $applicant)
              <li>
                {{ $applicant->name }} - CV:
                @if ($applicant->cv)
                  <a href="{{ route('viewCv', $applicant->cv->id) }}" target="_blank">{{ $applicant->cv->first_name }}
                    {{ $applicant->cv->last_name }}</a>
                @else
                  @lang('messages.recruiter_view_applicants.no_cv')
                @endif
              </li>
            @endforeach
          </ul>
        </div>
      @endforeach

      <script>
        document.addEventListener("DOMContentLoaded", function() {
          var dropdown = document.getElementById('jobListingsDropdown');

          dropdown.addEventListener('change', function() {
            var selectedJobListingId = this.value;

            // Hide all containers
            document.querySelectorAll('.applicants-container').forEach(function(container) {
              container.style.display = 'none';
            });

            // Show the selected container if there's more than one job listing,
            // or if there's only one job listing and it matches the selected ID
            var selectedContainer = document.getElementById('applicantsContainer' + selectedJobListingId);
            if (selectedContainer) {
              selectedContainer.style.display = 'block';
            }
          });
        });
      </script>
    @else
      {{-- Only one job listing, display applicants directly --}}
      <div class="applicants-container" id="applicantsContainer{{ $jobListings[0]->id }}">
        <h3>{{ $jobListings[0]->job_title }} @lang('messages.recruiter.applicants'):</h3>
        <ul>
          @foreach ($jobListings[0]->applicants as $applicant)
            <li>
              {{ $applicant->name }} - CV:
              @if ($applicant->cv)
                <a href="{{ route('viewCv', $applicant->cv->id) }}" target="_blank">{{ $applicant->cv->first_name }}
                  {{ $applicant->cv->last_name }}</a>
              @else
                @lang('messages.recruiter_view_applicants.no_cv')
              @endif
            </li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>

@endsection

@section('footer')
  @include('includes.footer')
@endsection
