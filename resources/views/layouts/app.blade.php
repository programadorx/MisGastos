<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="navbar-header">
                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>
        </nav>

        <div class="row">

            <div class="col s3"> </div>
            <div class="col s6">
            
            <div class="card">
                    <div class="card-content">
                         <p>Bienvenido.</p>
                    </div>
                <div class="card-tabs">            
                    <ul class="tabs tabs-fixed-width">
                     @if (Auth::guest())
                        <li class="tab"><a class="active" href="{{ route('login') }}">Login</a></li>
                        <li class="tab"><a href="{{ route('register') }}">Registro</a></li>
                     @else

                        <li class="tab">
                            <a href="{{ route('logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Cerrar</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                     @endif
                     </ul>
                </div>
                <div class="card-content grey lighten-4">
                     @yield('content')
                </div>
            </div>
           
        </div>
        </div>
    </div>

    <!-- Scripts -->
    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="{{asset('js/materialize.min.js')}}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
