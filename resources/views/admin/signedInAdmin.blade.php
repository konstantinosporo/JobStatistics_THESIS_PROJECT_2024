<!-- resources/views/admin/statistics.blade.php -->

@extends('layouts.layoutStatistics') <!-- Assuming you have a layout for statistics -->

@section('customCSS')
  @vite('resources/css/icons/icons.css')
  <!-- Include additional CSS as needed for the admin panel -->
@endsection

@section('navbar')
  @include('admin.includes.nav.navbarSignedInAdmin')
  @include('includes.colorMode')
@endsection

@section('content')
  <div class="container">
    @if (isset($admin))
      <h1 class="mb-4">Welcome, <i class="bi bi-fingerprint me-1 text-success"></i>{{ $admin->name }}!</h1>
      <p class="lead"><i class="bi bi-arrow-return-right me-1"></i>Explore the statistics and insights below.</p>
      <hr class="border-1 text-success">
    @else
      <p>Admin not available</p>
      <hr class="border-1 text-danger">
    @endif

    <div class="row justify-content-center m-lg-auto">
      <!-- Total Users Chart -->
      <div class="col-md-5 col-lg-3 col-8 card shadow-lg p-4 m-1">
        <canvas id="totalUsersChart" width="400" height="400"></canvas>
        <figcaption class="text-center mt-2">
          <small><i class="bi bi-person-fill"></i> Total Users</small>
        </figcaption>
      </div>
      <hr class="border-1 text-success d-block d-lg-none d-md-none m-auto">

      <!-- Job Listings and Job Applications Chart -->
      <div class="col-md-5 col-lg-3 col-8 card shadow-lg p-3 m-1 m-lg-auto">
        <canvas id="jobListingsChart" width="400" height="400"></canvas>
        <figcaption class="text-center mt-2">
          <small><i class="bi bi-briefcase-fill"></i> Job Listings & Applications</small>
        </figcaption>
      </div>
      <hr class="border-1 text-success d-block d-lg-none d-md-none m-auto">
      <!-- Sent and Received Messages Chart -->
      <div class="col-md-5 col-lg-3 col-8 card shadow-lg p-4 m-1">
        <canvas id="messagesChart" width="400" height="400"></canvas>
        <figcaption class="text-center mt-2">
          <small><i class="bi bi-envelope-fill"></i> Sent & Received Messages</small>
        </figcaption>
      </div>
    </div>
  </div>
@endsection

@section('footer')
  @include('includes.footer')
@endsection

@section('specialJS')
  <script>
    // Total Users Chart
    var totalUsersCtx = document.getElementById('totalUsersChart').getContext('2d');
    var totalUsersChart = new Chart(totalUsersCtx, {
      type: 'polarArea',
      data: {
        labels: ['Applicants', 'Admins', 'Recruiters'],
        datasets: [{
          label: 'Users Statistics',
          data: [{{ $userCount }}, {{ $adminCount }}, {{ $recruiterCount }}],
          backgroundColor: [
            '#a1aece', // Red for Applicants
            '#435d9d', // Deep Blue for Admins
            '#7285b5' // Amber for Recruiters
          ],
          borderColor: [
            '#a1aece',
            '#435d9d',
            '#7285b5'
          ],
          borderWidth: 1,
          barPercentage: 0.6, // Adjust this value to control the width of the bars
          categoryPercentage: 0.5
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              precision: 0
            }
          }
        }
      }
    });
  </script>


  <script>
    // Job Listings and Job Applications Chart
    var jobListingsCtx = document.getElementById('jobListingsChart').getContext('2d');
    var jobListingsChart = new Chart(jobListingsCtx, {
      type: 'bar',
      data: {
        labels: ['Job Listings', 'Job Applications'],
        datasets: [{
          label: '@lang('messages.misc.jobs_statistics')',
          data: [{{ $jobListingsCount }}, {{ $jobApplicationsCount }}],
          backgroundColor: [
            '#7285b5', // Cyan for Job Listings
            '#a1aece' // Red for Job Applications
          ],
          borderColor: [
            '#7285b5',
            '#a1aece'
          ],
          borderWidth: 1,
          barPercentage: 0.8, // Adjust this value to control the width of the bars
          categoryPercentage: 0.7
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              precision: 0
            }
          }
        }
      }
    });
  </script>

  <script>
    // Sent and Received Messages Chart
    var messagesCtx = document.getElementById('messagesChart').getContext('2d');
    var messagesChart = new Chart(messagesCtx, {
      type: 'doughnut',
      data: {
        labels: ['User Messages', 'Recruiter Messages'],
        datasets: [{
          label: 'Message Statistics',
          data: [{{ $sentMessagesFromUsersCount }}, {{ $sentMessagesFromRecruitersCount }}],
          backgroundColor: [
            '#a1aece', // Cyan for User Messages
            '#7285b5' // Red for Recruiter Messages
          ],
          borderColor: [
            '#a1aece',
            '#7285b5'
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              precision: 0
            }
          }
        }
      }
    });
  </script>
@endsection
