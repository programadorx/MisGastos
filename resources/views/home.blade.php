<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Mis Gastos</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
  
  <div class="navbar-fixed"> <!--fija -->
      <nav class="teal lighten-1" role="navigation">
        <div class="nav-wrapper container">
          <a id="logo-container" href="#" class="brand-logo">Logo</a>
          <ul class="right hide-on-med-and-down">
            <li><a href="#">Registro</a></li>
            <li><a href="#">Aplicacion</a></li>
            <li><a href="#">Contacto</a></li>
          </ul>

          <ul id="nav-mobile" class="side-nav">
            <li><a href="#">Registro</a></li>
            <li><a href="#">Aplicacion</a></li>
            <li><a href="#">Contacto</a></li>
          </ul>
          <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
        </div>        
      </nav>
  </div> <!--fija -->

  <div class="section no-pad-bot" id="index-banner">
    <div class="container">
      <br><br>
      <h1 class="header center orange-text">Mis Gastos</h1>
      <div class="row center">
        <h5 class="header col s12 light">La forma sencilla de llevar tu contabilidad</h5>
      </div>
      <div class="row center">
        <a href="" id="download-button" class="btn-large waves-effect waves-light orange">Comenzar</a>
      </div>
      <br><br>

    </div>
  </div>

  <div class="section no-pad-bot" id="index-banner">
    <div class="container">
         <div class="carousel">
        <a class="carousel-item" href="#one!"><img src="https://lorempixel.com/300/300/nature/1"></a>
        <a class="carousel-item" href="#two!"><img src="https://lorempixel.com/300/300/nature/2"></a>
        <a class="carousel-item" href="#three!"><img src="https://lorempixel.com/300/300/nature/3"></a>
        <a class="carousel-item" href="#four!"><img src="https://lorempixel.com/300/300/nature/4"></a>
        <a class="carousel-item" href="#five!"><img src="https://lorempixel.com/300/300/nature/5"></a>
    </div>

    </div>
  </div>




  <div class="container">
    <div class="section">
     
      <div class="row">
      
        <div class="col s12 m6 red">
          <div class="icon-block">
            <h2 class="center light-blue-text"><i class="material-icons">flash_on</i></h2>
            <h5 class="center">Speeds up development</h5>

            <p class="light">We did most of the heavy lifting for you to provide a default stylings that incorporate our custom components. Additionally, we refined animations and transitions to provide a smoother experience for developers.</p>
          </div>
        </div>

        <div class="col s12 m6">
            <div class="card">
            <div class="card-content">
                    <h2 class="center green-text"><i class="medium material-icons">group</i></h2>
                    <h5 class="center">Registrate Ya!</h5>
            </div>
            <div class="card-tabs">
              <ul class="tabs tabs-fixed-width">
                @if (Auth::guest())
                <li class="tab"><a class="active" href="#login">Login</a></li>
                <li class="tab"><a href="#register">Registro</a></li>
                @else
                   <li class="tab"><a href="#salir">Cerrar</a>

                </li>
                @endif
              </ul>
            </div>
            <div class="card-content grey lighten-4">
                @if (Auth::guest())
                    <div id="login">    
                        @include('auth.milogin')
                    </div>            
                    
                    <div id="register">
                        @include('auth.miregister')

                    </div>
                @else
                    <div id="salir" style="margin-left: 40%;">
                        <a href="{{ route('logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> <i class="medium material-icons">keyboard_tab</i></a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>

                    </div>
                @endif
            </div>
          </div>

        </div>
                <div class="col s12 m6 red">
          <div class="icon-block">
            <h2 class="center light-blue-text"><i class="material-icons">flash_on</i></h2>
            <h5 class="center">Speeds up development</h5>

            <p class="light">We did most of the heavy lifting for you to provide a default stylings that incorporate our custom components. Additionally, we refined animations and transitions to provide a smoother experience for developers.</p>
          </div>
        </div>
      </div> <!--row -->

    </div><!--section -->
    <br><br>
  </div>




  <footer class="page-footer teal lighten-1">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text">Company Bio</h5>
          <p class="grey-text text-lighten-4">We are a team of college students working on this project like it's our full time job. Any amount would help support and continue development on this project and is greatly appreciated.</p>


        </div>
        <div class="col l3 s12">
          <h5 class="white-text">Settings</h5>
          <ul>
            <li><a class="white-text" href="#!">Link 1</a></li>
            <li><a class="white-text" href="#!">Link 2</a></li>
            <li><a class="white-text" href="#!">Link 3</a></li>
            
          </ul>
        </div>
        <div class="col l3 s12">
          <h5 class="white-text">Connect</h5>
          <ul>
            <li><a class="white-text" href="#!">Link 1</a></li>
            <li><a class="white-text" href="#!">Link 2</a></li>
            <li><a class="white-text" href="#!">Link 3</a></li>
            
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
      Realizado por <a class="orange-text text-lighten-3" href="#">GP</a>
      </div>
    </div>
  </footer>


  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="{{asset('js/materialize.js')}}"></script>
  <script>
      


        $('.carousel').carousel();
        $('.button-collapse').sideNav();
        $('.modal').modal();

  </script>

  </body>
</html>
