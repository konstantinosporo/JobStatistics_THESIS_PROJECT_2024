@extends('layouts.layoutStatistics')

@section('customCSS')
  @vite('resources/css/icons/icons.css')
@endsection

@section('navbar')
  @include('students.includes.nav.navbarSignedIn')
@endsection

@section('colorMode')
  @include('includes.colorMode')
@endsection


@section('search')
  <div class="container">
    @include('students.includes.navTabs.statNavTabs')
    <div class="row d-flex justify-content-between mt-3">
      <div class="col-lg-8 col-md-7 col-12 d-flex align-items-center">
        <h5 class=" fw-light"><i class="bi bi-arrow-return-right me-1"></i>@lang('messages.user_graph.statistics_for') <span class="text-success">
            @if (isset($selectedCategory) && $selectedCategory)
              @if (app()->getLocale() == 'en')
                {{ $selectedCategory->english_name }}.
              @else
                {{ $selectedCategory->greek_name }}.
          </span>
          @endif
        @else
          <span class="text-danger">@lang('messages.user_graph.no_results')</span>
          @endif
        </h5>
      </div>

      <div class="col-lg-4 col-md-5 col-12">
        <form class="d-flex mt-3 mt-lg-0" role="search"
          action="{{ $getSearchAction($currentRouteName = request()->route()->getName()) }}" method="GET">
          <div class="input-group">
            <span class="input-group-text" id="searchIcon">
              <i class="bi bi-search"></i>
            </span>
            <input class="form-control" id="searchInput1" type="search" name="query"
              placeholder="{{ $getSearchPlaceholder($currentRouteName) }}" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">@lang('messages.misc.search')</button>
          </div>
          <div id="suggestionBox1">
          </div>
        </form>
      </div>

    </div>

    <hr class="border border-1 border-success opacity-25">
  </div>
@endsection

@section('graph')


  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="col-lg-10 col-md-7 col-12">
        <div class="mt-2">
          <canvas id="employeeStatisticsChart"></canvas>

          <figcaption class="figure-caption text-end">
            <div class="wide-mode-info d-block d-sm-none text-warning float-start">
              <i class="bi bi-info-circle"></i>
              <span>Switch to wide mode for a better experience</span>
            </div>
            <i class="bi bi-database-check mx-1"></i>@lang('messages.user_graph.elstat')
          </figcaption>

        </div>
      </div>
    </div>

    <hr class="border border-1 border-success opacity-25">

    <div class="row d-flex justify-content-around align-content-center m-0 p-1 mt-4">
      <!-- Column for Job Description -->
      <div class="col-lg-9 col-md-7 col-12  border-0">
        <div class="card border-0 shadow-sm p-3">
          <div class="header-expand card-header-pills fs-5 fw-light"><i class="bi bi-info-circle text-info"></i></i>
            @lang('messages.user_graph.job_description')</div>
          @if (isset($jobDescription) && $jobDescription)
            <div class="job-description">
              <p>
                @if (app()->getLocale() == 'en')
                  {{ $jobDescription->jobdescriptionenglish }}
                @else
                  {{ $jobDescription->jobdescriptiongreek }}
                @endif
              </p>
            </div>
          @else
            <div class="job-description pt-1">
              <span class="text-danger fw-light">@lang('messages.user_graph.no_results')</span>
            </div>
          @endif
        </div>
      </div>
    </div>


  </div>
@endsection


@section('footer')
  @include('includes.footer')
@endsection

@section('script')
  <script>
    const ctx = document.getElementById('employeeStatisticsChart').getContext('2d');
    var gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(0, 114, 167, 0.3)');
    gradient.addColorStop(1, 'rgba(75, 192, 2, 0.2)');

    const chart = new Chart(ctx, {
      type: 'line', // or 'bar', 'pie', etc.
      data: {
        labels: @json($data->pluck('year')),
        datasets: [{
          label: '{{ __('messages.user_graph.number_of_employees') }}',
          data: @json($data->pluck('total_employees')),
          backgroundColor: gradient,
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          x: {
            type: 'category',
            labels: @json($data->pluck('year')),
            grid: {
              display: true,
              color: 'rgba(0, 0, 0, 0.1)',
              lineWidth: 1
            },
            ticks: {
              font: {
                size: 12
              }
            },
            title: {
              display: true,
              text: '{{ __('messages.user_graph.years') }}',
            },
            beginAtZero: true
          },
          y: {
            beginAtZero: true,
            grid: {
              display: true,
              color: 'rgba(0, 0, 0, 0.1)',
              lineWidth: 1
            },
            ticks: {
              font: {
                size: 14
              },
              callback: function(value, index, values) {
                return value.toLocaleString() +
                  'k'; // Display values in thousands with 'k' as a unit
              }
            },
            title: {
              display: true,
              text: '{{ __('messages.user_graph.number_of_employees') }}', // Add a unit to the axis title

            }
          }
        }
      }
    });
  </script>
@endsection
