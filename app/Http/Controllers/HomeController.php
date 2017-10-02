<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('home');
    }


    //voy a usar de pruebas todo este index x ahora
     //   $user=Auth::user();
     //   $ingresos_gastos=Auth::user()->balances; 
        //dd($user->balances); imprime todo sus ingresos y egresos
    /* 
         foreach ($user->balances as $ingreso) {
             echo "soy el ingreso o gasto ".$ingreso->id." mi descrip: ".$ingreso->descripcion." <br>";
         }
         

         esta bien relacionado, ya que un balance
         conoce a su user, por lo tanto su nombre

         $unBalance=$ingresos_gastos->first();

         dd($unBalance->user->name);
        
    */

    //  dd($user->balances->first()->clasificacion->user->name);
    //  dd($user->balances->first()->clasificacion->categoria->nombre);
    //  dd($user->balances->first()->clasificacion->item->nombre);

    //  dd($user->balances->first()->clasificacion->balances);
         /*
        $unaClasi=$user->clasificaciones->first();
        dd($unaClasi->item->nombre);


        // dd($user->clasificaciones);
         foreach ($user->clasificaciones as $cla) {
         echo "soy la clasificacion ".$cla->id." usuario: ".$cla->usuario_id." <br>";
         echo "mi categoria es ".$cla->categoria->nombre." item: ".$cla->item->nombre." <br>---++---<br>";
         }
    */

}
