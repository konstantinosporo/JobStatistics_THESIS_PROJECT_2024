@extends('layouts.layout')

@section('customCSS')
  @vite('resources/css/icons/icons.css')
@endsection

@section('navbar')
  @include('recruiter.includes.nav.navbarSignedInRecruiter')
@endsection

@section('includes')
  @include('includes.colorMode')
@endsection


@section('tabs')
  <div class="container mt-5">
    <div class="row d-flex">
      <div class="col-12">
        @include('recruiter.includes.navTabs.job_listings_tabs')
      </div>
    </div>
    <div class="row">
      @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          <strong><i class="bi bi-check2-circle me-1"></i></strong> @lang('messages.recruiter.listing_update_success')
        </div>
      @endif
      @if ($errors->any())
        <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          <ul>
            @foreach ($errors->all() as $error)
              <li><i class="bi bi-exclamation-circle-fill me-1"></i>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
    </div>
  </div>
@endsection


@section('content')
  <div class="d-flex align-items-center my-4 pb-5">
    <div class="container mb-5">
      <div class="row d-flex justify-content-center">
        <div class="col-12 col-md-7 col-lg-6">
          <h2 class=" fw-light mb-3"><i class="bi bi-plus-circle-dotted me-1 fs-4"></i>@lang('messages.recruiter.create_job_listing')</h2>
          <form action="{{ route('job_listings.store') }}" method="POST" class="card p-3 shadow">
            @csrf
            <div class="mb-3">
              <label for="job_category" class="form-label">@lang('messages.user_job_listings.job_category')</label>
              <div class="input-group">
                <label for="job_category" class="input-group-text">
                  <i class="bi bi-briefcase"></i>
                </label>
                <input type="text" name="job_category" id="job_category" class="form-control" autocomplete="off">
                <div id="suggestions-container"></div>
                <input type="hidden" name="job_category_id" id="job_category_id">
              </div>
            </div>
            <div class="mb-3">
              <label for="job_title" class="form-label">@lang('messages.user_job_listings.job_title')</label>
              <div class="input-group">
                <label for="job_title" class="input-group-text">
                  <i class="bi bi-card-heading"></i>
                </label>
                <input type="text" name="job_title" id="job_title" class="form-control" required>
              </div>
            </div>
            <div class="mb-3">
              <label for="job_description" class="form-label">@lang('messages.user_job_listings.job_description')</label>
              <div class="input-group">
                <label for="job_description" class="input-group-text">
                  <i class="bi bi-file-text"></i>
                </label>
                <textarea name="job_description" id="job_description" class="form-control" rows="4" required></textarea>
              </div>
            </div>
            <div class="mb-3">
              <label for="location" class="form-label">@lang('messages.user_job_listings.job_location')</label>
              <div class="input-group">
                <label for="location" class="input-group-text">
                  <i class="bi bi-geo-alt"></i>
                </label>
                <input type="text" name="location" id="location" class="form-control" required>
              </div>
            </div>
            <div class="mb-3">
              <label for="qualifications" class="form-label">@lang('messages.user_job_listings.job_qualifications')</label>
              <div class="input-group">
                <label for="qualifications" class="input-group-text">
                  <i class="bi bi-award"></i>
                </label>
                <textarea name="qualifications" id="qualifications" class="form-control" rows="4" required></textarea>
              </div>
            </div>
            <a href="#">
              <button type="submit" class="btn btn-primary float-end">
                <i class="bi bi-file-earmark-plus me-1"></i>@lang('messages.recruiter.job_listing')
              </button>
            </a>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

<script>
  document.addEventListener("DOMContentLoaded", function() {
    var jobCategoryInput = document.getElementById('job_category');
    var jobCategoryIdInput = document.getElementById('job_category_id');
    var suggestionsContainer = document.getElementById('suggestions-container');

    jobCategoryInput.addEventListener('input', function() {
      var query = jobCategoryInput.value;

      if (query.length > 1) {
        fetch(`/suggest-job-categories-recruiter?query=${encodeURIComponent(query)}`)
          .then(response => response.json())
          .then(data => {
            suggestionsContainer.innerHTML = '';
            data.forEach(suggestion => {
              var suggestionItem = document.createElement('div');
              suggestionItem.textContent = suggestion
                .english_name; // Use the suggestion english_name
              suggestionItem.classList.add('suggestion');
              suggestionItem.addEventListener('click', function() {
                jobCategoryInput.value = suggestion.english_name;
                jobCategoryIdInput.value = suggestion
                  .id; // Set job_category_id
                suggestionsContainer.innerHTML = '';
              });
              suggestionsContainer.appendChild(suggestionItem);
            });
          })
          .catch(error => console.error('Error fetching suggestions:', error));
      } else {
        suggestionsContainer.innerHTML = '';
      }
    });



    // Hide suggestion box when clicking outside
    document.addEventListener('click', function(event) {
      if (!jobCategoryInput.contains(event.target)) {
        suggestionsContainer.innerHTML = '';
      }
    });
  });
</script>

@section('footer')
  @include('includes.footer')
@endsection
