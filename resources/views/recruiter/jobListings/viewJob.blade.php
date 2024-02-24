@extends('layouts.layout')

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
  </div>
@endsection

@section('content')
  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="col-12 col-md-8 col-lg-8 ">
        @if (session('updateSuccess'))
          <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong><i class="bi bi-check2-circle me-1"></i></strong> @lang('messages.recruiter.listing_update_success')
          </div>
        @endif
        @if (session('deleteSuccess'))
          <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong><i class="bi bi-check2-circle me-1"></i></strong> @lang('messages.recruiter.listing_delete_success')
          </div>
        @endif
      </div>
    </div>

    <div class="row justify-content-center m-4">
      @if ($jobListings->count() > 0)
        @foreach ($jobListings as $jobListing)
          <div class="col-md-6 mb-4">
            <div class="card p-3">
              <p><strong>@lang('messages.user_job_listings.job_category')</strong>
                @if (app()->getLocale() == 'en')
                  {{ $job_categories->find($jobListing->job_category_id)->english_name ?? 'Unknown Category' }}
                @else
                  {{ $job_categories->find($jobListing->job_category_id)->greek_name ?? 'Unknown Category' }}
                @endif
              </p>
              <p><strong>@lang('messages.user_job_listings.job_title')</strong> {{ $jobListing->job_title }}</p>
              <p><strong>@lang('messages.user_job_listings.job_description')</strong> {{ $jobListing->job_description }}</p>
              <p><strong>@lang('messages.user_job_listings.job_location')</strong> {{ $jobListing->location }}</p>
              <p><strong>@lang('messages.user_job_listings.job_qualifications')</strong> {{ $jobListing->qualifications }}</p>

              <div class="container">
                <!-- Modal -->
                <div class="modal fade" id="editModal{{ $jobListing->id }}" tabindex="-1"
                  aria-labelledby="editModalLabel{{ $jobListing->id }}" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel{{ $jobListing->id }}">Edit Job
                          Listing</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <!-- Edit Form -->
                        <form action="{{ route('job_listings.update', $jobListing->id) }}" method="POST">
                          @csrf
                          @method('PATCH')

                          <div class="mb-3">
                            <label for="job_title" class="form-label">Job Title:</label>
                            <input type="text" id="job_title" name="job_title" value="{{ $jobListing->job_title }}"
                              class="form-control" required>
                          </div>

                          <div class="mb-3">
                            <label for="job_description" class="form-label">Job
                              Description:</label>
                            <textarea id="job_description" name="job_description" class="form-control" required>{{ $jobListing->job_description }}</textarea>
                          </div>

                          <div class="mb-3">
                            <label for="location" class="form-label">Location:</label>
                            <input type="text" id="location" name="location" value="{{ $jobListing->location }}"
                              class="form-control" required>
                          </div>

                          <div class="mb-3">
                            <label for="qualifications" class="form-label">Qualifications:</label>
                            <textarea id="qualifications" name="qualifications" class="form-control" required>{{ $jobListing->qualifications }}</textarea>
                          </div>

                          <div class="mb-3">
                            <label for="job_category_id" class="form-label">Job
                              Category:</label>
                            <select id="job_category_id" name="job_category_id" class="form-select" required>
                              @foreach ($job_categories as $category)
                                <option value="{{ $category->id }}"
                                  {{ $category->id == $jobListing->job_category_id ? 'selected' : '' }}>
                                  {{ $category->english_name }}
                                </option>
                              @endforeach
                            </select>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"><i
                                class="bi bi-floppy me-1"></i>@lang('messages.recruiter.save')</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                                class="bi bi-x-circle me-1"></i>@lang('messages.recruiter.discard')</button>
                          </div>

                        </form>
                      </div>

                    </div>
                  </div>
                </div>

                <div class="container-fluid d-flex justify-content-between align-items-center p-sm-0 m-sm-0">
                  <small class="p-0 m-0">
                    <strong class="me-1">Posted:</strong>{{ $jobListing->created_at }}
                  </small>

                  <div class="d-flex">
                    <button type="button" class="btn btn-warning text-white d-none d-lg-block" data-bs-toggle="modal"
                      data-bs-target="#editModal{{ $jobListing->id }}" title="Edit Job">
                      <i class="bi bi-pencil"></i> @lang('messages.recruiter.edit')
                    </button>


                    <button type="button" class="btn btn-danger text-white ms-1 d-none d-lg-block"
                      data-job-id="{{ $jobListing->id }}" data-bs-toggle="modal"
                      data-bs-target="#deleteConfirmationModal{{ $jobListing->id }}" title="Delete Job">
                      <i class="bi bi-trash"></i> @lang('messages.buttons.delete')
                    </button>

                    <!-- Buttons with text for small screens -->
                    <button type="button" class="btn btn-warning text-white d-lg-none" data-bs-toggle="modal"
                      data-bs-target="#editModal{{ $jobListing->id }}" title="Edit Job">
                      <i class="bi bi-pencil"></i>
                    </button>


                    <button type="button" class="btn btn-danger delete-btn ms-2 d-lg-none"
                      data-job-id="{{ $jobListing->id }}" data-bs-toggle="modal"
                      data-bs-target="#deleteConfirmationModal{{ $jobListing->id }}" title="Delete Job">
                      <i class="bi bi-trash"></i>
                    </button>

                  </div>
                </div>

              </div>
            </div>
          </div>

          <!-- Delete Confirmation Modal -->
          <div class="modal fade" id="deleteConfirmationModal{{ $jobListing->id }}" tabindex="-1" role="dialog"
            aria-labelledby="deleteConfirmationModalLabel{{ $jobListing->id }}" aria-hidden="true">
            @include('recruiter.includes.modals.deleteJobModal')
          </div>
        @endforeach
      @endif
    </div>
  </div>
@endsection

@section('footer')
  @include('includes.footer')
@endsection

@section('specialJS')
  <!-- Your Bootstrap modal code -->
  <script>
    $(document).ready(function() {
      $('#saveChangesButton').click(function() {
        // Get the data from the form inside the modal
        var formData = $('#editForm').serialize();

        // Send an AJAX request to update the job listing
        $.ajax({
          url: '/job_listings/' + jobId,
          type: 'PUT',
          data: formData,
          success: function(response) {
            // Handle success, close the modal, show a message, etc.
            console.log(response.message);
            $('#editModal').modal('hide');
          },
          error: function(xhr) {
            // Handle errors if necessary
            console.log(xhr.responseText);
          }
        });
      });
    });
  </script>
@endsection
