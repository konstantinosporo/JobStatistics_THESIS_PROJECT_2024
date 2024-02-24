@extends('layouts.layout')

@section('navbar')
  @include('students.includes.nav.navbarSignedIn')
@endsection

@section('includes')
  @include('includes.colorMode')
@endsection

@section('content')
  <div class="container mt-5 mb-5">
    <div class="row justify-content-center">
      <div class="col-sm-12 col-lg-7 col-md-8">

        @if ($cv)
          <!-- if CV exists, display update form -->
          <h2 class="fw-light"><i class="bi bi-pencil me-2"></i>
            @lang('messages.user.edit_my_cv')</h2>
          <hr class="border border-warning border-1 opacity-50">
          @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @elseif (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('error') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          <form action="{{ route('updateCv') }}" method="post" enctype="multipart/form-data"
            class="card shadow border-0 p-3">
            @csrf

            <div class="container">
              <div class="row justify-content-center">
                <div class="col-6">
                  <div class="mb-1">
                    <label for="first_name" class="form-label">@lang('messages.user_edit_fields.edit_first_name')</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-person-gear"></i></span>
                      <input type="text" name="first_name" id="first_name" placeholder="First Name" required
                        class="form-control" value="{{ $cv->first_name ?? '' }}">
                    </div>
                  </div>

                  <div class="mb-1">
                    <label for="last_name" class="form-label">@lang('messages.user_edit_fields.edit_last_name')</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-person-gear"></i></i></span>
                      <input type="text" name="last_name" id="last_name" placeholder="Last Name" required
                        class="form-control" value="{{ $cv->last_name ?? '' }}">
                    </div>
                  </div>
                </div>


                <div class="col-6 d-flex justify-content-center">
                  <!-- Inside the col-6 where the image is displayed -->
                  <div class="image-container">
                    @if ($cv->photo)
                      <img src="{{ Storage::url($cv->photo) }}" alt="CV Photo" class="img-thumbnail ">
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
                  <div class="mb-2">
                    <label for="date_of_birth" class="form-label">@lang('messages.user_edit_fields.edit_date_of_birth')</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                      <input type="date" name="date_of_birth" id="date_of_birth" placeholder="Date of Birth" required
                        class="form-control" value="{{ $cv->date_of_birth ?? '' }}">
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-12">
                  <div class="mb-2">
                    <label for="phone_number" class="form-label">@lang('messages.user_edit_fields.edit_phone_number')</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-phone"></i></span>
                      <input type="text" name="phone_number" id="phone_number" placeholder="Phone Number" required
                        class="form-control" value="{{ $cv->phone_number ?? '' }}">
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-12">
                  <div class="mb-2">
                    <label for="proficiency" class="form-label p-0">@lang('messages.user_edit_fields.edit_proficiency')</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-star"></i></span>
                      <input type="text" name="proficiency" id="proficiency" placeholder="Proficiency" required
                        class="form-control" value="{{ $cv->proficiency ?? '' }}">
                    </div>
                  </div>
                </div>
              </div>


              <div class="row">
                <div class="col-12">
                  <div class="mb-1">
                    <label for="description" class="form-label">@lang('messages.user_edit_fields.edit_description')</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                      <textarea name="description" id="description" placeholder="Description" rows="3" required
                        class="form-control" style="resize: none;">{{ $cv->description ?? '' }}</textarea>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-12">
                  <div class="mb-1">
                    <label for="experience" class="form-label">@lang('messages.user_edit_fields.edit_experience')</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                      <textarea name="experience" id="experience" placeholder="Experience" rows="3" required class="form-control"
                        style="resize: none;">{{ $cv->experience ?? '' }}</textarea>
                    </div>
                  </div>
                </div>
              </div>


              <div class="row">
                <div class="col-12">
                  <div class="mb-1">
                    <label for="photo" class="form-label">@lang('messages.user_edit_fields.edit_photo')</label>
                    <input type="file" name="photo" id="photo" class="form-control mt-2">
                    <small class="form-text text-muted">@lang('messages.user_edit_fields.photo_size')</small>

                  </div>
                </div>
              </div>

              <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-primary me-2">
                  <i class="bi bi-pencil-square me-1"></i>@lang('messages.buttons.update_cv')
                </button>

                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                  data-bs-target="#deleteConfirmationModal">
                  <i class="bi bi-trash"></i> @lang('messages.buttons.delete_cv')
                </button>
              </div>
            </div>
          </form>

          <div class="modal fade" id="deleteConfirmationModal" tabindex="-1"
            aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="deleteConfirmationModalLabel"><i
                      class="bi bi-exclamation-triangle-fill text-warning me-1"></i>@lang('messages.admin.delete_title')</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  @lang('messages.admin.are_you_sure')
                </div>
                <div class="modal-footer">

                  <form action="{{ route('deleteCv') }}" method="post" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i
                        class="bi bi-trash"></i>@lang('messages.buttons.delete_cv')</button>

                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                      <i class="bi bi-x-circle me-1"></i>@lang('messages.admin.cancel')</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        @else
          <!-- if CV doesn't exist, display create form -->
          <h2 class="fw-light"> <i class="bi bi-plus-circle-dotted me-2 "></i>@lang('messages.user.create_my_cv')</h2>
          <hr class="border border-success border-1 opacity-50">
          @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @elseif (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('error') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @elseif (session('deleteCvSuccess'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('deleteCvSuccess') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          <form action="{{ route('storeCv') }}" method="post" enctype="multipart/form-data"
            class="card shadow border-0 p-4">
            @csrf

            <div class="mb-1">
              <label for="first_name" class="form-label">@lang('messages.user_profile_fields.first_name')</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" name="first_name" id="first_name" required class="form-control">
              </div>
            </div>

            <div class="mb-1">
              <label for="last_name" class="form-label">@lang('messages.user_profile_fields.last_name')</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" name="last_name" id="last_name" required class="form-control">
              </div>
            </div>

            <div class="mb-1">
              <label for="date_of_birth" class="form-label">@lang('messages.user_profile_fields.date_of_birth')</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                <input type="date" name="date_of_birth" id="date_of_birth" required class="form-control">
              </div>
            </div>

            <div class="mb-1">
              <label for="phone_number" class="form-label">@lang('messages.user_profile_fields.phone_number')</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-phone"></i></span>
                <input type="tel" name="phone_number" id="phone_number" required class="form-control">
              </div>
            </div>

            <div class="mb-1">
              <label for="proficiency" class="form-label">@lang('messages.user_profile_fields.proficiency')</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-star"></i></span>
                <input type="text" name="proficiency" id="proficiency" required class="form-control">
              </div>
            </div>

            <div class="mb-1">
              <label for="description" class="form-label">@lang('messages.user_profile_fields.description')</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                <textarea name="description" id="description" rows="5" required class="form-control"></textarea>
              </div>
            </div>

            <div class="mb-1">
              <label for="experience" class="form-label">@lang('messages.user_profile_fields.experience')</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                <textarea name="experience" id="experience" rows="5" required class="form-control" style="resize: none;"></textarea>
              </div>
            </div>

            <div class="mb-1 p-1">
              <label for="photo" class="form-label">@lang('messages.user_profile_fields.cv_photo')</label>
              <input type="file" name="photo" id="photo" class="form-control mb-1" required>
              <small class="form-text text-muted">@lang('messages.user_edit_fields.photo_size')</small>
            </div>

            <a href="#">
              <button type="submit" class="btn btn-primary mt-3 float-end"><i
                  class="bi bi-plus me-1"></i>@lang('messages.user.create_my_cv')</button>
            </a>
          </form>
        @endif
      </div>
    </div>
  </div>
@endsection

@section('footer')
  @include('includes.footer')
@endsection
