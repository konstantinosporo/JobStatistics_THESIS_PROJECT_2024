@extends('layouts.layout')


@section('navbar')
  @include('includes.navbar.navbarSignedOut')
@endsection

@section('includes')
  @include('includes.colorMode')
@endsection

@section('form')
  @include('includes.forms.signUpForm')
@endsection

@section('footer')
  @include('includes.footer')
@endsection
