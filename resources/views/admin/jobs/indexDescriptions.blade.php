<!-- resources/views/admin/jobs/index.blade.php -->

@extends('layouts.layout')

@section('customCSS')
  @vite('resources/css/icons/icons.css')
@endsection

@section('navbar')
  @include('admin.includes.nav.navbarSignedInAdmin')
@endsection

@section('includes')
  @include('includes.colorMode')
@endsection

@section('content')
  <div class="container mt-4 p-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="fw-light">@lang('messages.admin_job_table.jobs_table_title')</h3>
      <div class="input-group" style="max-width: 344px;"> <!-- Set your desired max-width -->
        <form class="d-flex mt-3 mt-lg-0" role="search"
          action="{{ $getSearchAction($currentRouteName = request()->route()->getName()) }}" method="GET">
          <div class="input-group">
            <span class="input-group-text" id="searchIcon">
              <i class="bi bi-search"></i>
            </span>
            <input class="form-control" id="searchInput3" type="search" name="query"
              placeholder="{{ $getSearchPlaceholder($currentRouteName) }}" aria-label="Search">
            <button class="btn btn-outline-primary" type="submit">@lang('messages.misc.search')</button>
          </div>
          <div id="suggestionBox3">
          </div>
        </form>
      </div>
    </div>
    <hr class="border-1 text-primary">

    @if (session('updateSuccess'))
      <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong><i class="bi bi-check2-circle me-1"></i></strong> @lang('messages.admin_job_table.success_alert')
      </div>
    @endif
    @if (session('deleteSuccess'))
      <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong><i class="bi bi-check2-circle me-1"></i></strong> @lang('messages.admin_job_table.delete_success_alert')
      </div>
    @endif
    @if (session('updateError'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-x-circle me-1"></i> @lang('messages.admin_job_table.error_alert')
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    @if (session('deleteError'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-x-circle me-1"></i> @lang('messages.admin_job_table.error_alert')
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <table class="table table-hover table-striped">
      <caption><i class="bi bi-table me-1"></i>@lang('messages.admin_job_table.total') {{ $jobDescriptions->total() }}</caption>
      <thead>
        <tr>
          <th>@lang('messages.admin_job_table.id')</th>
          <th>@lang('messages.admin_job_table.job_description')</th>
          <th>@lang('messages.admin_job_table.job_category')</th>
          <th>
            @lang('messages.admin_job_table.action')
            <a href="{{ route('admin.jobs.indexDescriptions') }}" class="text-decoration-none ms-2">
              <button class="btn btn-primary p-0 m-0 px-1 float-end"><i class="bi bi-arrow-counterclockwise"></i></button>
            </a>
          </th>

        </tr>
      </thead>
      <tbody>
        @foreach ($jobDescriptions as $jobDescription)
          <tr>
            <td>{{ $jobDescription->id }}</td>
            <td class="w-50">
              @if (app()->getLocale() == 'el')
                <textarea name="jobdescriptiongreek" class="form-control" disabled>{{ $jobDescription->jobdescriptiongreek }}</textarea>
              @else
                <textarea name="jobdescriptionenglish" class="form-control" disabled>{{ $jobDescription->jobdescriptionenglish }}</textarea>
              @endif
            </td>
            <td class="w-50">
              @if (app()->getLocale() == 'el')
                <textarea name="jobdescriptiongreek" class="form-control" disabled>{{ $jobDescription->job->jobCategory->greek_name }}</textarea>
              @else
                <textarea name="jobdescriptionenglish" class="form-control" disabled> {{ $jobDescription->job->jobCategory->english_name }}</textarea>
              @endif
            </td>

            <td>
              <div class="d-flex justify-content-end p-0">

                <button type="button" class="btn btn-primary edit-btn d-none d-lg-block" data-bs-toggle="modal"
                  data-bs-target="#editJobModal{{ $jobDescription->id }}">
                  <i class="bi bi-pencil"></i>
                  <span class="">@lang('messages.recruiter.edit')</span>
                </button>
                <button type="button" class="btn btn-danger delete-btn ms-2 d-none d-lg-block"
                  data-job-id="{{ $jobDescription->id }}" data-bs-toggle="modal"
                  data-bs-target="#deleteConfirmationModal{{ $jobDescription->id }}">
                  <i class="bi bi-trash"></i>
                  <span class="visually-hidden">@lang('messages.buttons.delete')</span>
                </button>

                <button type="button" class="btn btn-primary edit-btn d-lg-none" data-bs-toggle="modal"
                  data-bs-target="#editJobModal{{ $jobDescription->id }}">
                  <i class="bi bi-pencil"></i>

                </button>
                <button type="button" class="btn btn-danger delete-btn ms-2 d-lg-none"
                  data-job-id="{{ $jobDescription->id }}" data-bs-toggle="modal"
                  data-bs-target="#deleteConfirmationModal{{ $jobDescription->id }}">
                  <i class="bi bi-trash"></i>

                </button>
              </div>
            </td>
          </tr>

          <!-- Edit Job Modal -->
          <div class="modal fade" id="editJobModal{{ $jobDescription->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editJobModalLabel{{ $jobDescription->id }}" aria-hidden="true">
            @include('admin.includes.modals.editJobModal')
          </div>

          <!-- Delete Confirmation Modal -->
          <div class="modal fade" id="deleteConfirmationModal{{ $jobDescription->id }}" tabindex="-1" role="dialog"
            aria-labelledby="deleteConfirmationModalLabel{{ $jobDescription->id }}" aria-hidden="true">
            @include('admin.includes.modals.deleteJobModal')
          </div>
        @endforeach
      </tbody>
    </table>

    <div class="d-flex justify-content-center">
      {{ $jobDescriptions->links() }}
    </div>
  </div>
@endsection

@section('footer')
  @include('includes.footer')
@endsection
