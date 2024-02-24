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
        <h5 class=" fw-light"><i class="bi bi-arrow-return-right me-1"></i> @lang('messages.user_graph.statistics_for') <span class="text-success">
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
            <input class="form-control" id="searchInput2" type="search" name="query"
              placeholder="{{ $getSearchPlaceholder($currentRouteName) }}" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">@lang('messages.misc.search')</button>
          </div>
          <div id="suggestionBox2">
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
      <div class="col-lg-6 col-md-8 col-12">
        <div class="mt-2">
          <canvas id="employeeStatisticsChart"></canvas>
          <figcaption class="figure-caption text-end"><i class="bi bi-database-check mx-1"></i>@lang('messages.user_graph.elstat')
          </figcaption>
        </div>
      </div>
    </div>
    <hr class="border border-1 border-success opacity-25">

    <div class="row d-flex justify-content-around align-content-center m-0 p-1 mt-4">
      <!-- Column for Job Description -->
      <div class="col-lg-9 col-md-6 col-12  border-0">
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

    const chart = new Chart(ctx, {
      type: 'polarArea', // or 'bar', 'pie', etc.
      data: {
        labels: @json($data->pluck('year')),
        datasets: [{
          label: '{{ __('messages.user_graph.number_of_employees') }}',
          data: @json($data->pluck('total_employees')),
          backgroundColor: [
            // 28 χρώματα για κάθε χρόνο από 1995-2022
            'rgba(255, 99, 132, 0.5)', 'rgba(54, 162, 235, 0.5)', 'rgba(255, 206, 86, 0.5)',
            'rgba(75, 192, 192, 0.5)', 'rgba(153, 102, 255, 0.5)',
            'rgba(255, 159, 64, 0.5)',
            'rgba(255, 99, 132, 0.5)', 'rgba(54, 162, 235, 0.5)', 'rgba(255, 206, 86, 0.5)',
            'rgba(75, 192, 192, 0.5)', 'rgba(153, 102, 255, 0.5)',
            'rgba(255, 159, 64, 0.5)',
            'rgba(199, 199, 199, 0.5)', 'rgba(233, 30, 99, 0.5)', 'rgba(33, 150, 243, 0.5)',
            'rgba(76, 175, 80, 0.5)', 'rgba(255, 235, 59, 0.5)', 'rgba(255, 87, 34, 0.5)',
            'rgba(121, 85, 72, 0.5)', 'rgba(96, 125, 139, 0.5)', 'rgba(255, 193, 7, 0.5)',
            'rgba(205, 220, 57, 0.5)', 'rgba(158, 158, 158, 0.5)',
            'rgba(103, 58, 183, 0.5)',
            'rgba(0, 150, 136, 0.5)', 'rgba(255, 87, 34, 0.5)', 'rgba(121, 85, 72, 0.5)',
            'rgba(96, 125, 139, 0.5)'
          ],
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

  <script></script>
@endsection
