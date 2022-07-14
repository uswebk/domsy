<!doctype html>
<html lang='{{ str_replace('_', '-', app()->getLocale()) }}'>

<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <meta name='csrf-token' content='{{ csrf_token() }}'>

  <title>{{ config('app.name', 'Laravel') }}</title>

  <script src='{{ asset('js/app.js') }}' defer></script>

  <link rel='dns-prefetch' href='//fonts.gstatic.com'>
  <link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet'>
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
  <link href='{{ asset('css/app.css') }}' rel='stylesheet'>
</head>

<body>
  <div id='app'>
    {{-- @include('layouts.header')
    <main class='py-4 d-flex justify-content-center' id='app'>
      @yield('sidebar')
    </main> --}}
    @yield('content')
  </div>
</body>

</html>
