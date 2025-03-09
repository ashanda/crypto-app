<!DOCTYPE html>
<html lang="en">

<head> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Primary Meta Tags -->
    <title>signetint</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('resources/assets/img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('resources/assets/img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('resources/assets/img/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('resources/assets/img/favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('resources/assets/img/favicon/safari-pinned-tab.svg') }}" color="#ffffff">

    <link type="text/css" href="{{ asset('resources/vendor/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">

    <!-- Notyf -->
    <link type="text/css" href="{{ asset('resources/vendor/notyf/notyf.min.css') }}" rel="stylesheet">
    <!-- CSS -->
    <link type="text/css" href="{{ asset('resources/css/volt.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('resources/css/custome.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body>
    @include('sweetalert::alert')
    @yield('sidebar')
    @yield('content')
    @yield('footer')

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="{{ asset('resources/vendor/@popperjs/core/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('resources/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <!-- Additional JS libraries -->
    <script src="{{ asset('resources/vendor/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('resources/assets/js/volt.js') }}"></script>
    <script src="{{ asset('resources/assets/js/custome.js') }}"></script>
    @yield('scripts')
</body>
</html>