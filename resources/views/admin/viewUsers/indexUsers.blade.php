<!-- resources/views/admin/users/index.blade.php -->
@extends('layouts.layout')

@section('customCSS')
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
      <h3 class="fw-light">@lang('messages.admin_user_table.user_table_title')</h3>
      <div class="input-group" style="max-width: 340px;"> <!-- Set your desired max-width -->
        <form class="d-flex mt-3 mt-lg-0" role="search"
          action="{{ $getSearchAction($currentRouteName = request()->route()->getName()) }}" method="GET">
          <div class="input-group">
            <span class="input-group-text" id="searchIcon">
              <i class="bi bi-search"></i>
            </span>
            <input class="form-control" id="searchInput4" type="search" name="query"
              placeholder="{{ $getSearchPlaceholder($currentRouteName) }}" aria-label="Search">
            <button class="btn btn-outline-primary" type="submit">@lang('messages.misc.search')</button>
          </div>
          <div id="suggestionBox4">
          </div>
        </form>
      </div>
    </div>
    <hr class="border-1 text-primary">

    @if (session('updateSuccess'))
      <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong><i class="bi bi-check2-circle me-1"></i></strong> @lang('messages.admin_user_table.success_alert')
      </div>
    @endif
    @if (session('deleteSuccess'))
      <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong><i class="bi bi-check2-circle me-1"></i></strong> @lang('messages.admin_user_table.delete_success_alert')
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
      <caption>@lang('messages.admin_user_table.total') {{ $users->total() }}</caption>
      <thead>
        <tr>
          <th>@lang('messages.admin_user_table.id')</th>
          <th>@lang('messages.admin_user_table.name')</th>
          <th>@lang('messages.admin_user_table.email')</th>
          <th>@lang('messages.admin_user_table.user_type')</th>
          <th>@lang('messages.admin_user_table.created_at')</th>
          <th class="d-flex justify-content-end">
            <span class="me-lg-5">@lang('messages.admin_job_table.action')</span>
            <a href="{{ route('admin.viewUsers.indexViewUsers') }}" class="text-decoration-none ">
              <button class="btn btn-primary p-0 m-0 px-1 float-end"><i class="bi bi-arrow-counterclockwise"></i></button>
            </a>
          </th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $user)
          <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role }}</td>
            <td>{{ $user->created_at }}</td>
            <td>
              <div class="d-flex justify-content-end p-0">

                <button type="button" class="btn btn-primary edit-btn d-none d-lg-block" data-bs-toggle="modal"
                  data-bs-target="#editUserModal{{ $user->id }}">
                  <i class="bi bi-pencil"></i>
                  <span class="">@lang('messages.recruiter.edit')</span>
                </button>
                <button type="button" class="btn btn-danger delete-btn ms-2 d-none d-lg-block"
                  data-job-id="{{ $user->id }}" data-bs-toggle="modal"
                  data-bs-target="#deleteUserModal{{ $user->id }}">
                  <i class="bi bi-trash"></i>
                  <span class="visually-hidden">@lang('messages.buttons.delete')</span>
                </button>

                <button type="button" class="btn btn-primary edit-btn d-lg-none" data-bs-toggle="modal"
                  data-bs-target="#editUserModal{{ $user->id }}">
                  <i class="bi bi-pencil"></i>

                </button>
                <button type="button" class="btn btn-danger delete-btn ms-2 d-lg-none" data-job-id="{{ $user->id }}"
                  data-bs-toggle="modal" data-bs-target="#deleteUserModal{{ $user->id }}">
                  <i class="bi bi-trash"></i>

                </button>
              </div>
            </td>
          </tr>

          <!-- Edit User Modal -->
          <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
            @include('admin.includes.modals.editUserModal')
          </div>

          <!-- Delete Confirmation Modal -->
          <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1" role="dialog"
            aria-labelledby="deleteUserModalLabel{{ $user->id }}" aria-hidden="true">
            @include('admin.includes.modals.deleteUserModal')
          </div>
        @endforeach
      </tbody>
    </table>

    <div class="d-flex justify-content-center">
      {{ $users->links() }}
    </div>
  </div>
@endsection




@section('footer')
  @include('includes.footer')
@endsection
