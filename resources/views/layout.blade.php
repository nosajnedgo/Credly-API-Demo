<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <title>Credly API Demo - @yield('title')</title>
    <link rel="stylesheet" type="text/css" href="/css/app.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>

  <body>

    <nav>
      <div class="container-fluid">
        <img class="logo" src="https://credlystatic.s3.amazonaws.com/img/logo_white.png">
        @yield('nav')
      </div>
    </nav>

    @yield('content')

  </body>
</html>
