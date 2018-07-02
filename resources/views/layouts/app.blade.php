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
            <a class="nav-link" href="{{ url('/master-data') }}">Master Data <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Users</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="{{ url('/reports') }}">Reports</a>
            </li>
            </ul>
            <ul class="navbar-nav my-2 my-lg-0">
                <li>
                    <a class="nav-link text-right" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">Logout <i class="fa fa-sign-out" aria-hidden="true"></i></a>
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


    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="logoutModalLabel">Ready to Leave?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Select "Logout" below if you are ready to end your current session.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

            <a class="btn btn-primary" href="javascript::void(0);" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Confirm</a>

              <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
            </form>
          
          </div>
        </div>
      </div>
    </div>

    </div>
    <!-- end app -->

    <!-- Scripts -->
    <script src="{{ asset('js/all.js') }}"></script>
    @yield('script')
    
</body>
</html>
