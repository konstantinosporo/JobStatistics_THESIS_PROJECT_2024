@extends('layouts.layout')

@section('customCSS')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('navbar')
  @include('recruiter.includes.nav.navbarSignedInRecruiter')
@endsection

@section('includes')
  @include('includes.colorMode')
@endsection

@section('header')
  @include('recruiter.includes.carousel.carouselRecruiter')
@endsection

@section('content')
  <div class="container mt-5 mb-3">
    @if (isset($recruiter))
      <h1 class="mb-3 fw-light"> @lang('messages.welcome') <i
          class="bi bi-person-check me-1 text-success fs-3"></i>{{ $recruiter->name }}!
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
  <div class="container mt-3">
    <div class="row d-flex justify-content-around">
      <div class="col-12 col-md-8 col-lg-8 card shadow p-3">
        <canvas id="myChart" class="chart-container"></canvas>
        <figcaption class="figure-caption"><i class="bi bi-bar-chart-line me-1 text-success"></i>@lang('messages.recruiter.graph_caption')
        </figcaption>
      </div>
      <div class="col-12 col-md-4 col-lg-3 card p-3">
        <canvas id="myChart" class="chart-container"></canvas>
        <figcaption class="figure-caption text-end"> @lang('messages.user_graph.elstat')</figcaption>
      </div>
    </div>
  </div>
@endsection

@section('footer')
  @include('includes.footer')
@endsection

@section('specialJS')
  <script>
    var ctx = document.getElementById('myChart').getContext('2d');
    // Create a linear gradient for the background color
    var gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(0, 114, 167, 0.3)'); // Start color
    gradient.addColorStop(1, 'rgba(75, 192, 2, 0.2)'); // End color
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: @json($labels),
        datasets: [{
          label: '@lang('messages.recruiter_view_applicants.num_of_applicants')',
          data: @json($data),
          backgroundColor: gradient,
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          x: {
            title: {
              display: true,
              text: '"@lang('messages.user_job_listings.job_listings')"', // label for x
            }
          },
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: '', // label for y

            }
          }
        },

      }
    });
  </script>
@endsection
