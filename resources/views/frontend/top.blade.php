<!DOCTYPE html>
<html lang='{{ str_replace('_', '-', app()->getLocale()) }}'>

<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>

  <title>Domsy</title>

  <!-- Fonts -->
  <link href='https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap' rel='stylesheet'>


  <style>

    * {
      background-color: #e8c46a;
      color: #5684d5;
    }
    html {
      height:100%;
    }
    body {
      font-family: 'Nunito', sans-serif;
      margin: 0;
      height:100%;
    }

  </style>

<link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet'>
<link href='{{ asset('css/app.css') }}' rel='stylesheet'>
<script src='{{ asset('js/app.js') }}' defer></script>

</head>

<body>
  <div class='d-flex flex-column align-items-center justify-content-center h-100'>
    <div>
      <img src='{{ asset('image/domsy.jpg') }}' alt='' class="d-block mx-auto w-75">
    </div>
    <div>
      @auth
        <a href='{{ route('dashboard.index') }}' class='text-sm text-gray-700 dark:text-gray-500'>Dashboard</a>
      @else
        <a href='{{ route('login') }}' class='text-sm text-gray-700 dark:text-gray-500'>Log in</a>
        <a href='{{ route('register.index') }}' class='ml-4 text-sm text-gray-700 dark:text-gray-500'>Register</a>
      @endauth
    </div>
  </div>
</body>

</html>
