  <!DOCTYPE html>
  <html lang="{{ app()->getLocale() }}" class="h-100"> <!-- Main layout that is extended to most of my blade files. -->

  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="Statistical based web application about career paths.">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <link rel="manifest" href="{{ asset('pwa/manifest.json') }}"> {{-- PWA FOR PROGRESSIVE WEB APPLICATION --}}
      <link rel="icon" href="{{ asset('img\logo.png') }}">
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      @vite('resources/css/app.css')

      @yield('customCSS')

      <title>JobsStatistics</title>
  </head>

  <body>
      @yield('colorMode')



      <!--Progress Bar (Global)-->
      @include('partials.progressBar')
      <!-- Instead of long html line i use laravel 'yield' for better code reading-->
      @yield('navbar')


      <main class="mt-5">
          @yield('heading')
          @yield('myForm')
      </main>

      @yield('search')
      @yield('content')

      <section>
          @yield('graph')
      </section>


      <div class="container footer-container">
          @yield('footer')
      </div>


      @if (isset($data))
          @yield('script')
      @else
      @endif

      <!-- Modules/Scripts -->
      <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
      @vite('resources/js/app.js')
      @vite('resources/js/myJs/colorTheme.js')
      @vite('resources/js/myJs/msg.js')
      @yield('specialJS')
  </body>

  </html>
