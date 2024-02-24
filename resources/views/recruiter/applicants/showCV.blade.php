<!-- resources/views/cvs/view.blade.php -->
@extends('layouts.layout')

@section('includes')
  @include('includes.colorMode')
@endsection

@section('content')
  <div class="container">
    <h2 class="my-5">@lang('messages.recruiter_view_applicants.showing_cv') {{ $cv->first_name }} {{ $cv->last_name }} </h2>
    @if ($cv)
      <!-- Display CV information -->
      <div class="card shadow border-0 p-3">
        <div class="container">
          <h2 class="text-center mb-4">@lang('messages.recruiter_view_applicants.cv_details')</h2>

          <div class="row">
            <div class="col-6">
              <div class="mb-3">
                <label for="first_name" class="form-label">@lang('messages.user_profile_fields.first_name')</label>
                <input type="text" id="first_name" class="form-control" value="{{ $cv->first_name }}" readonly>
              </div>

              <div class="mb-3">
                <label for="last_name" class="form-label">@lang('messages.user_profile_fields.last_name')</label>
                <input type="text" id="last_name" class="form-control" value="{{ $cv->last_name }}" readonly>
              </div>
            </div>

            <div class="col-6 d-flex justify-content-center">
              <!-- Inside the col-md-6 where the image is displayed -->
              <div class="image-container">
                @if ($cv->photo)
                  <img src="{{ Storage::url($cv->photo) }}" alt="CV Photo" class="img-thumbnail">
                @else
                  <!-- Default image or placeholder if no photo is available -->
                  <img src="{{ asset('img/default-photo.png') }}" alt="Default Photo" class="img-thumbnail"
                    style="max-width: 150px; max-height: 150px; border-radius: 50%;">
                @endif
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="mb-3">
                <label for="date_of_birth" class="form-label">@lang('messages.user_profile_fields.date_of_birth')</label>
                <input type="text" id="date_of_birth" class="form-control" value="{{ $cv->date_of_birth }}" readonly>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="mb-3">
                <label for="phone_number" class="form-label">@lang('messages.user_profile_fields.phone_number')</label>
                <input type="text" id="phone_number" class="form-control" value="{{ $cv->phone_number }}" readonly>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="mb-3">
                <label for="proficiency" class="form-label">@lang('messages.user_profile_fields.proficiency')</label>
                <input type="text" id="proficiency" class="form-control" value="{{ $cv->proficiency }}" readonly>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="mb-3">
                <label for="description" class="form-label">@lang('messages.user_profile_fields.description')</label>
                <textarea id="description" class="form-control" readonly>{{ $cv->description }}</textarea>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="mb-3">
                <label for="experience" class="form-label">@lang('messages.user_profile_fields.experience')</label>
                <textarea id="experience" class="form-control" readonly>{{ $cv->experience }}</textarea>
              </div>
            </div>
          </div>

        </div>
      </div>
      <div class="container d-flex justify-content-end"><button class="btn btn-danger mt-3" onclick="goBack()"><i
            class="bi bi-arrow-left me-1"></i>@lang('messages.buttons.back')</button></div>
    @else
      <!-- Handle case when CV doesn't exist -->
      <div class="alert alert-info mt-3" role="alert">
        @lang('messages.recruiter_view_applicants.no_cv_info')
      </div>
    @endif

  </div>

  <script>
    function goBack() {
      window.close(); // close the window
    }
  </script>
@endsection


@section('footer')
  @include('includes.footer')
@endsection
