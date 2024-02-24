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
      <h3 class=" fw-light">@lang('messages.welcome') {{ $user->name }}!</h3>
    @else
      <p>@lang('messages.user.user_not_available')</p>
    @endif
  </div>
@endsection

@section('component')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-8 col-md-5 col-lg-5 text-center bg-light-subtle shadow-lg rounded-3">
        <h3 class="fs-5 mt-2">@lang('messages.content.whats_new')</h3>
        <ul class="list-group">
          <li class="text-center list-group-item bg-info-subtle mt-2">
            <span><x-polaris-major-jobs width="30" height="30" class="text-success" />
            </span>
            @lang('messages.content.job_opportunities')
          </li>
          <!-- Add a sample list item for testing -->
          <li class="text-center list-group-item bg-light-subtle mt-2">
            <span><x-pepicon-cv width="24" height="24" class="text-success" />
            </span>
            @lang('messages.content.resume_builder')
          </li>
          <li class="text-center list-group-item bg-info-subtle mt-2 mb-4">
            <span><x-uiw-message width="20" height="20" class="text-success" />
            </span>
            @lang('messages.content.check_our_graphs')
          </li>
        </ul>
      </div>
    </div>
  </div>
@endsection

@section('footer')
  @include('includes.footer')
@endsection
