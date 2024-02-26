@extends('layouts.layout')

@section('navbar')
  @include('students.includes.nav.navbarSignedIn')
@endsection

@section('includes')
  @include('includes.colorMode')
@endsection

@section('header')
  @include('students.includes.carousel.carouselStudent')
@endsection

@section('content')
  <div class="container mt-5 mb-3">
    @if (isset($user))
      <h1 class="mb-3 fw-light">@lang('messages.welcome') <i
          class="bi bi-person-check me-1 text-success fs-3"></i>{{ $user->name }}!
      </h1>
      <p class="lead"><i class="bi bi-arrow-return-right me-1"></i>@lang('messages.misc.explore_statistics')</p>
      <hr class="border-1 text-success">
    @else
      <p>@lang('messages.user.user_not_available')</p>
      <hr class="border-1 text-danger">
    @endif
  </div>
@endsection

@section('component')
  <div class="container my-4">
    <div class="row d-flex justify-content-center">

      <div class="col-12 col-md-6 col-lg-6 d-flex flex-column">
        @include('students.includes.partials.userPreferences', ['userPreferences' => $userPreferences])
      </div>

      <div class="col-12 col-md-6 col-lg-6 text-center rounded-3 d-flex flex-column mt-5 mt-md-0 mt-lg-0">
        <h5 class="fw-light text-start"><i class="bi bi-bell-fill text-primary me-2"></i>
          @lang('messages.content.whats_new')</h5>
        <hr class="border border-primary border-1 opacity-50">
        <div class="card border-0 shadow flex-fill p-2">
          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              <i class="bi bi-briefcase-fill me-1 text-danger"></i>
              @lang('messages.content.job_opportunities')
            </li>
            <li class="list-group-item"><i class="bi bi-file-earmark-person-fill me-1 text-success"></i>
              @lang('messages.content.resume_builder')</li>
            <li class="list-group-item"><i class="bi bi-graph-up me-1 text-primary"></i>
              @lang('messages.content.check_our_graphs')</li>
          </ul>

          <div class="card-footer">
            Card footer
          </div>
        </div>
      </div>

    </div>
  </div>
@endsection

@section('footer')
  @include('includes.footer')
@endsection
