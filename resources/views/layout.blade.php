<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  
  <title>Mis Gastos</title>

  <!-- CSS  -->

  <!--Import Google Icon Font-->
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>

  <!--Import materialize.css-->
  <link type="text/css" rel="stylesheet" href="{{asset('css/materialize.css')}}"  media="screen,projection"/>
  
  <!-- Css personalizado-->
  <link type="text/css" rel="stylesheet" href="{{asset('css/style.css')}}" media="screen,projection"/>

  <!--Import select2.css -->
  <link rel="stylesheet" type="text/css" href="{{asset('css/select2.css')}}">
  
  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body>

<header>
  <nav class="teal darken-3">
    <div class="nav-wrapper">

      <ul id="slide-out" class="side-nav fixed">
        <li>
          <div class="user-view">
            
            <div class="background grey lighten-3">
                    <!-- aca iria una imagen de fondo y la class solo se llama background --> 
            </div>

            <div class="center-align black-text">
             <i class="large material-icons">face</i>
            </div>
            <a href="#!name"><span class="black-text name">Hola {{Auth::user()->name }} !!</span></a>
            <a href="#!email"><span class="black-text email">{{Auth::user()->email }}</span></a>

          </div>
        </li>

        <li>
          <a href="{{ route('logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
          <i class="material-icons">input</i> Salir </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
            </form>
        </li>

        <li>
          <a href="#!"><i class="material-icons">account_box</i> Mi Perfil</a>
        </li>
        <li>
          <div class="divider"></div>
        </li>
      
     
        <li class="no-padding">
          <ul class="collapsible" data-collapsible="expandable">
            <li>
              <a class="collapsible-header">Balance<i class="material-icons">account_balance</i></a>
              <div class="collapsible-body">
                <ul>
                  <li> 
                    <a class="waves-effect waves-teal " href="{{url('/balance')}}"><i class="material-icons">insert_chart_outlined</i>Historico</a>
                  </li> 
                  <li><a href="{{action('BalanceController@filtrado')}}"><i class="material-icons">search</i>Filtrar</a></li>
                </ul>
              </div>
            </li>
          </ul>
        </li>

        <li class="no-padding">
            <ul class="collapsible" data-collapsible="expandable">
              <li>
                <a class="collapsible-header">Ingresos<i class="material-icons">call_made</i></a>
                <div class="collapsible-body">
                  <ul>
                      <li> 
                       <a class="waves-effect waves-teal " href="{{url('/ingreso')}}"><i class="material-icons">trending_up</i>Ingresos</a>
                      </li> 
                    <li><a href="{{url('/ingreso/estadisticas')}}"><i class="material-icons">insert_chart_outlined</i>Estadisticas</a></li>

                  </ul>
                </div>
              </li>
              </ul>
        </li>

        <li class="no-padding">
            <ul class="collapsible" data-collapsible="expandable">
              <li>
                <a class="collapsible-header">Egresos<i class="material-icons">call_received</i></a>
                <div class="collapsible-body">
                  <ul>
                      <li> 
                       <a class="waves-effect waves-teal" href="{{url('/egreso')}}"><i class="material-icons">trending_down</i>Egresos</a>
                      </li> 
                    <li><a href="{{url('/egreso/estadisticas')}}"><i class="material-icons">insert_chart_outlined</i>Estadisticas</a></li>

                  </ul>
                </div>
              </li>
              </ul>
        </li>

        <li class="no-padding">
            <ul class="collapsible" data-collapsible="expandable">
              <li>
                <a class="collapsible-header">Configurar<i class="material-icons">build</i></a>
                <div class="collapsible-body">
                  <ul>
                    <li><a class="waves-effect waves-teal" href="{{url('/clasificacion')}}"><i class="material-icons">shuffle</i>Clasifiacion</a>
                    </li>
                    <li>
                      <a class="waves-effect waves-teal" href="{{url('/item')}}"><i class="material-icons">add</i>Items</a>
                    </li>
                    <li>
                      <a class="waves-effect waves-teal" href="{{url('/categoria')}}"><i class="material-icons">dehaze</i>Categorias</a>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
        </li>

        <li>
          <ul class="collapsible" data-collapsible="expandable">
          <li>
            <a class="collapsible-header" href="#">Ayuda<i class="material-icons">help</i></a>
            <div class="collapsible-body">
            <ul>
              <li><a href="#!">First</a></li>
              <li><a href="#!">Second</a></li>
              <li><a href="#!">Third</a></li>
              <li><a href="#!">Fourth</a></li>
            </ul>
            </div>
          </li>
          </ul> 
          </li>


      </ul> 

      <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
  </nav>
</header>




<main>
<div class="container">

  @yield('contenido')


</div>

</main>
  <!--Import jQuery before materialize.js-->
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="{{asset('js/materialize.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/select2.js')}}"></script>
  <!--Aplica la hamburguesa si es desde el cel -->
 
  <script>

    $(document).ready(function(){
        $(".button-collapse").sideNav();
        $('.collapsible').collapsible();
     });
     

  </script> 

    @if(Session::has('aviso'))
      <script>
        Materialize.toast("{{ Session::get('aviso') }}", 2500, 'amber darken-4');  
      </script>
    @endif
    @if(Session::has('guardar'))
      <script>
        Materialize.toast("{{ Session::get('guardar') }}", 2500, 'green darken-1');  
      </script>
    @endif
    @if(Session::has('eliminar'))
      <script>
        Materialize.toast("{{ Session::get('eliminar') }}", 2500, 'red lighten-1');  
      </script>
    @endif

   @stack('scripts')
</body>

</html>

