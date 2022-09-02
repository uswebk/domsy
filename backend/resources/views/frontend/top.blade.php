<!DOCTYPE html>
<html lang='{{ str_replace('_', '-', app()->getLocale()) }}'>

<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>

  <title>Domsy</title>

  <link href='https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap' rel='stylesheet'>

  <link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet'>
  <link href='{{ asset('css/app.css') }}' rel='stylesheet'>
  <script src='{{ asset('js/app.js') }}' defer></script>

</head>

<body>
  <div id="app">
    <top-page></top-page>
  </div>
</body>
</html>
