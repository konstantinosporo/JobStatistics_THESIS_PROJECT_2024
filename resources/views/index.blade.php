@extends('layouts.layout')

@section('customCSS')
  @vite('resources/css/myCss/independentIndex/indIndex.css')
@endsection

@section('includes')
  @include('includes.svgs.indexSVG')
  @include('includes.colorMode')
@endsection

@section('component')
  <div class="custom-card text-center">
    <!-- Content for the center-right card -->
    <h1 class="display-5 fw-bold">@lang('messages.misc.jobs_statistics')</h1>
    <p class="fs-6">@lang('messages.index.signInToGetStarted')</p>
    <div class="d-flex justify-content-center align-items-center">
      <a class="btn btn-primary sign-in-btn" type="button" href="{{ route('signIn') }}">@lang('messages.buttons.sign_in')</a>
      <p class="px-3 pt-3">@lang('messages.misc.or')</p>
      <a class="btn btn-primary sign-up-btn" type="button" href="{{ route('signUp') }}">@lang('messages.buttons.sign_up')</a>
    </div>


    <a href="#" class="text-decoration-none">
      <p class="p-0 m-0 text-light ">@lang('messages.auth.areYouARecruiter')
      </p>
    </a>
  </div>
@endsection
