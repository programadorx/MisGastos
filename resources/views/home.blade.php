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
  
  <div class="navbar"> <!--fija -->
      <nav class=" grey darken-1" role="navigation">
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

  <div class="container">
    
    <div class="section">
     
      <div class="row">
        
        <div class="col s6 m6 l6">

          <div class="col s12 m12 l12 grey lighten-5">
            <div class="icon-block">
              <h2 class="center"><i class=" large material-icons">stay_primary_portrait</i></h2>
              <h5 class="center">Proximamente en App</h5>

              <p class="light">Estamos trabajando para que tengas una app facil y sencilla de utilizar.
               Podrás apuntar tus compras y llevar tu contabilidad en cualquier momento y lugar.</p>
            </div>
          </div>
        
          <div class="col s12 m12 l12 grey lighten-4">
            <div class="icon-block">
              <h2 class="center"><i class="large material-icons">add_shopping_cart</i></h2>
              <h5 class="center">Apunta tus ingresos y egreso</h5>

              <p class="light">LLeva tu contabilidad anotando de forma sencilla todos los ingresos y egresos que tenes a diario.

              </p>
            </div>
          </div>
        </div>
        <div class="col s6 m6 l6">
          
          <div class="card" style="margin-top: 0px;">

            <div class="card-content">
                    <h2 class="center"><i class="medium material-icons">group</i></h2>
                    <h5 class="center">Registrate Ya!</h5>
            </div>

            <div class="card-tabs">
              <ul class="tabs tabs-fixed-width">
                @if (Auth::guest())
                <li class="tab"><a class="active orange-text" href="#login">Login</a></li>
                <li class="tab"><a class="orange-text" href="#register">Registro</a></li>
                @else
                   <li class="tab"><a href="#salir">Cerrar</a>

                </li>
                @endif
              </ul>
            </div>

            <div class="card-content">
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
          </div> <!--card -->
        </div>
      </div> <!-- row -->

      <div class="row">

        <div class="col s12 m6 l6 grey lighten-5">
          <div class="icon-block">
            <h2 class="center"><i class="large material-icons">insert_chart</i></h2>
            <h5 class="center">Reportes estadisticos</h5>

            <p class="light">Podrás generar reportes tanto de tus ingresos y gastos, como tambien de  un producto en particular, o una categoria especifica.</p>
          </div>
        </div>
      
        <div class="col s12 m6 l6 grey lighten-4">
          <div class="icon-block">
            <h2 class="center"><i class="large material-icons">account_balance</i></h2>
            <h5 class="center">LLeva tu balance</h5>

            <p class="light">Cargar tus gastos o ingresos diarios te permitira saber cual es tu balance, cuanto te debe quedar o si estas en numeros rojos!</p>
          </div>
        </div>

      </div> <!--row -->

    </div><!--section -->
    <br><br>
  </div>




  <footer class="page-footer grey darken-1 center" style="padding-left: 0px;">
    <div>
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text">Sobre Nosotros</h5>
          <p class="grey-text text-lighten-4">Proyecto personal</p>


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
