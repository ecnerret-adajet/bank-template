<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('image/favicon.png') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">



        <nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar-static-top mb-3">
            <div class="container">
            <a class="navbar-brand" href="{{ url('/home') }}">Bank Template</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor03">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Companies <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Banks</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="{{ url('/reports') }}">Report</a>
            </li>
            </ul>
            <ul class="navbar-nav my-2 my-lg-0">
                <li>
                    <a class="nav-link text-right" href="#">Logout <i class="fa fa-sign-out" aria-hidden="true"></i></a>
                </li>
            </ul>
        </div>
            </div>
       
        </nav>

        <div class="mb-5" style="margin-bottom: 100px;">
            @yield('content')
        </div>

        <footer class="footer">
        <div class="container">
            <span class="text-muted">La Filipina Uy Gongco Group of Companies</span>
        </div>
        </footer>

    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/all.js') }}"></script>
    @yield('script')
    
</body>
</html>
