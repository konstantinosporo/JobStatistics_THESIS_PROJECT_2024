<!-- resources/views/includes/edit_job_modal.blade.php -->

<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="editJobModalLabel{{ $jobDescription->id }}">@lang('messages.admin_job_table.edit_job_modal_title')</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      @if (session('success'))
        <div class="alert alert-success" role="alert">
          @lang('messages.admin_job_table.edit_job_modal_title')
        </div>
      @endif

      @if (session('error'))
        <div class="alert alert-danger" role="alert">
          {{ session('error') }}
        </div>
      @endif

      <form method="post" action="{{ route('admin.jobs.update', $jobDescription->id) }}">
        @csrf
        @method('PATCH')

        <div class="mb-3">
          <label for="jobcategorygreek" class="form-label">@lang('messages.admin_job_table.job_category_greek_label')</label>
          <textarea name="jobcategorygreek" class="form-control">{{ $jobDescription->job->jobCategory->greek_name }}</textarea>
        </div>
        <div class="mb-3">
          <label for="jobcategoryenglish" class="form-label">@lang('messages.admin_job_table.job_category_english_label')</label>
          <textarea name="jobcategoryenglish" class="form-control">{{ $jobDescription->job->jobCategory->english_name }}</textarea>
        </div>
        <div class="mb-3">
          <label for="jobdescriptiongreek" class="form-label">@lang('messages.admin_job_table.job_description_greek_label')</label>
          <textarea name="jobdescriptiongreek" class="form-control">{{ $jobDescription->jobdescriptiongreek }}</textarea>
        </div>
        <div class="mb-3">
          <label for="jobdescriptionenglish" class="form-label">@lang('messages.admin_job_table.job_description_english_label')</label>
          <textarea name="jobdescriptionenglish" class="form-control">{{ $jobDescription->jobdescriptionenglish }}</textarea>
        </div>

        <!-- Add other form fields as needed -->

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"><i class="bi bi-pencil me-1"></i>@lang('messages.admin_job_table.update_job_button')
          </button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
              class="bi bi-x-circle me-1"></i>@lang('messages.admin.cancel')
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
