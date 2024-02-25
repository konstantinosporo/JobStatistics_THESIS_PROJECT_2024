<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="h-100"> <!-- Main layout that is extended to most of my blade files. -->

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Statistical based web application about career paths.">
    {{-- Used by Google's search engines and other services --}}
    <link rel="manifest" href="{{ asset('pwa/manifest.json') }}">
    <link rel="icon" href="{{ asset('img/logo.png') }}">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    @vite('resources/css/icons/icons.css')
    @vite('resources/css/app.css')
    @yield('customCSS')

    <title>JobsStatistics</title>
  </head>

  <body>

    <!-- Partials -->
    @yield('includes')
    <!--Progress Bar (Global)-->
    @include('partials.progressBar')
    @yield('navbar')
    <!-- Main body content -->
    @yield('header')
    @yield('form')
    @yield('tabs')
    @yield('content')
    @yield('component')


    <!-- Footer -->
    <div class="container footer-container">
      @yield('footer')
    </div>

   
    <!-- Modules/Scripts -->
    @vite('resources/js/app.js')
    @vite('resources/js/myJs/colorTheme.js')
    @vite('resources/js/myJs/msg.js')
    @yield('specialJS')
  </body>

</html>
