<!-- resources/views/admin/users/index.blade.php -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@extends('layouts.layout')

@section('navbar')
  @include('admin.includes.nav.navbarSignedInAdmin')
@endsection

@section('includes')
  @include('includes.colorMode')
@endsection

@section('content')
  <div class="container mt-4 p-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="fw-light">@lang('messages.admin_user_table.view_users')</h3>
      <div class="input-group" style="max-width: 300px;"> <!-- Set your desired max-width -->
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

    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if (session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <table class="table table-hover table-striped">
      <caption>Users Table - Total: {{ $users->total() }}</caption>
      <thead>
        <tr>
          <th>ID</th>
          <th>Όνομα</th>
          <th>Ηλ. Ταχυδρομείο</th>
          <th>Τύπος χρήστη</th>
          <th>Ενέργεια</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $user)
          <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role }}</td>
            <td>
              <div class="d-flex">
                <button type="button" class="btn btn-primary edit-btn" data-bs-toggle="modal"
                  data-bs-target="#editUserModal{{ $user->id }}">
                  <i class="bi bi-pencil"></i>
                  <span class="visually-hidden">Edit</span>
                </button>
                <button type="button" class="btn btn-danger delete-btn ms-2" data-user-id="{{ $user->id }}"
                  data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal{{ $user->id }}">
                  <i class="bi bi-trash"></i>
                  <span class="visually-hidden">Delete</span>
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
          <div class="modal fade" id="deleteConfirmationModal{{ $user->id }}" tabindex="-1" role="dialog"
            aria-labelledby="deleteConfirmationModalLabel{{ $user->id }}" aria-hidden="true">
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
