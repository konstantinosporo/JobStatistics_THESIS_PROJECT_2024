@if ($userPreferences)
  <!-- if CV exists, display update form -->
  <h5 class="fw-light"><i class="bi bi-star-fill text-warning me-2"></i>
    @lang('messages.user.edit_user_preferences')</h5>
  <hr class="border border-warning border-1 opacity-50">
  @if (session('updateSuccess'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check2-circle me-1"> </i>{{ session('updateSuccess') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
  @if (session('updateError'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="bi bi-x-circle me-1"></i> {{ session('updateError') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
  @if (session('createSuccess'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check2-circle me-1"> </i>{{ session('createSuccess') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
  @if (session('createError'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="bi bi-x-circle me-1"></i>{{ session('createError') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <form action="{{ route('updatePreferences') }}" method="post" class="card shadow border-0 p-3">
    @csrf
    <div class="container">
      <div class="row justify-content-center">

        <div class="mb-1">
          <label for="favourite_category" class="form-label">@lang('messages.user_edit_fields.edit_job_category')</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-heart"></i></span>
            <select name="favourite_category" id="favourite_category" class="form-select" required>
              <!-- Options for the favourite category (job category) -->
              @foreach ($jobCategories as $category)
                <option value="{{ $category->id }}"
                  {{ optional($userPreferences)->job_category_id == $category->id ? 'selected' : '' }}>
                  {{ $category->greek_name }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="mb-1">
          <label for="location" class="form-label">@lang('messages.user_edit_fields.edit_job_location')</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
            <input type="text" name="location" id="location" placeholder="" class="form-control"
              value="{{ optional($userPreferences)->location ?? '' }}">
          </div>
        </div>

        <div class="mb-1">
          <label for="job_title" class="form-label">@lang('messages.user_edit_fields.edit_job_title')</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-file-person"></i></span>
            <input type="text" name="job_title" id="job_title" placeholder="" class="form-control"
              value="{{ optional($userPreferences)->job_title ?? '' }}">
          </div>
        </div>

      </div>

      <div class="d-flex justify-content-end mt-3">
        <button type="submit" class="btn btn-primary me-2">
          <i class="bi bi-pencil-square me-1"></i>@lang('messages.buttons.update_preferences')
        </button>

        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal">
          <i class="bi bi-trash"></i> @lang('messages.buttons.delete')
        </button>
      </div>
    </div>
  </form>

  <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteConfirmationModalLabel"><i
              class="bi bi-exclamation-triangle-fill text-warning me-1"></i>@lang('messages.user.delete_user_preferences')</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          @lang('messages.admin.are_you_sure')
        </div>
        <div class="modal-footer">

          <form action="{{ route('deletePreferences') }}" method="post" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i>@lang('messages.buttons.delete')</button>

            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
              <i class="bi bi-x-circle me-1"></i>@lang('messages.admin.cancel')</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@else
  <!-- if CV doesn't exist, display create form -->
  <h5 class="fw-light"> <i class="bi bi-star-fill text-success me-2 "></i>@lang('messages.user.save_user_preferences')</h5>
  <hr class="border border-success border-1 opacity-25">

  @if (session('deleteSuccess'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check2-circle me-1"> </i>{{ session('deleteSuccess') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
  @if (session('deleteError'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="bi bi-x-circle me-1"></i> {{ session('deleteError') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="card shadow p-3 flex-fill border-0">
    <form method="POST" action="{{ route('storePreferences') }}">
      @csrf
      <!-- Job Category Field -->
      <div class="mb-1">
        <label for="job_category" class="form-label">Job Category</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
          <select name="job_category_id" id="job_category_id" class="form-select">
            @foreach ($jobCategories as $category)
              <option value="{{ $category->id }}"
                {{ optional($userPreferences)->job_category_id == $category->id ? 'selected' : '' }}>
                {{ $category->greek_name }}
              </option>
            @endforeach
          </select>
        </div>
      </div>
      <!-- Location Field -->
      <div class="mb-1">
        <label for="location" class="form-label">Location</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
          <input type="text" name="location" id="location" placeholder="" class="form-control"
            value="{{ optional($userPreferences)->location }}">
        </div>
      </div>
      <!-- Job Title Field -->
      <div class="mb-1">
        <label for="job_title" class="form-label">Job Title</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
          <input type="text" name="job_title" id="job_title" placeholder="" class="form-control"
            value="{{ optional($userPreferences)->job_title }}">
        </div>
      </div>
      <!-- Include other fields based on your requirements -->
      <button type="submit" class="btn btn-primary mt-2 float-end">Save Preferences</button>
    </form>
  </div>

@endif
