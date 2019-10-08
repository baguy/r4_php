<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ trans('application.config.name') }}{{ trans('application.config.nickname') }} - @yield('PAGE_TITLE')</title>

    <!-- Font Awesome 5 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    <!-- AdminLTE 3.0.0 Alpha -->
    <link rel="stylesheet" href="{{ asset('assets/_dist/css/adminlte.min.css') }}">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- ### LAYOUT: Folha de estilo personalizada ### -->
    <link rel="stylesheet" href="{{ asset('assets/css/_print.css') }}">

    @yield('STYLES')

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}"/>
  </head>

  <body id="body" data-url="{{ url('/') }}">
      
    <div class="container">

      @yield('MAIN')
      
    </div>

    <!-- ### BASIC SCRIPTS ### -->
    
    <!-- JQuery 3.3.1 -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap 4.1.3 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    @yield('SCRIPTS')

  </body>

</html>