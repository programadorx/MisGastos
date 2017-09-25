<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Balance;
use Session;
use DB;
use JavaScript; // para pasar datos a la vista directamente a javasrcipt
use Carbon\Carbon;


class BalanceController extends Controller{

    public function __construct(){        
        $this->middleware('auth');// solo puede acceder al controlador un usuario logueado

    }

    public function index(){

        // *****************Primer Grafico***********************   
   
        /*
            Es el total de ingreso y egreso historico. 
            dd($misBalances); es una coleccion > {egreso=>xxx,ingreso=>xxxx}
        */
        $misBalances=Auth::user()->balances()->groupBy('tipo')
        ->select(DB::raw('sum(monto) as suma,tipo'))->get()->pluck('suma','tipo'); 

        
        if ( !$misBalances->has('egreso') ) {
            $misBalances->put('egreso',0);
        }
        if ( !$misBalances->has('ingreso') ) {
            $misBalances->put('ingreso',0);
        }

        //*********************Segundo Grafico*****************

        $anual= DB::table('balances')->where('usuario_id','=',Auth::user()->id)
        ->select(DB::raw('YEAR(fecha) año'),'tipo',DB::raw('sum(monto) as suma')) 
        ->groupBy('año','tipo')->orderBy('año','asc')->get();
        /*  Obtengo coleccion con objetos asi agrupados por año y por tipo.
                +"año": 2017
                +"tipo": "egreso"
                +"suma": "10075.00"
        
            Luego lo convierto en un array e inicializo otro de forma correcta,
            para tener agrupado por año tanto ingresos como egresos para completarlo.
            el nuevo array tiene ingresos y egresos en 0 en caso
            que un año solo contenga uno o ingresos o gastos y luego lo completo

        */     

        $anual_array=$anual->toArray();
        $ingresos_egresos_anuales= array();

        foreach ($anual_array as $key) { 
            $ingresos_egresos_anuales[$key->año]=array('ingreso'=>0,'egreso'=>0);
        }    
        foreach ($anual_array as $key) { //completo el array bien formateado
          $ingresos_egresos_anuales[$key->año][$key->tipo]+= $key->suma;
        }   

        $claves_anios = array_keys($ingresos_egresos_anuales); 
        $ingresos_anios=array_pluck($ingresos_egresos_anuales,'ingreso');
        $egresos_anios=array_pluck($ingresos_egresos_anuales,'egreso');
        /*
            Separo todos los array para que vayan al grafico por separado
        */

        JavaScript::put([                
                'claves_anios' => $claves_anios,
                'ingresos_anios'=>$ingresos_anios,
                'egresos_anios'=>$egresos_anios,
                'misBalances'=>$misBalances
        ]);

        $mejorBalance=['anio'=>'','total'=>''];
        $peorBalance=['anio'=>'','total'=>''];
        $maxBalance=-9999999;
        $minBalance=999999999;
       
        foreach ($ingresos_egresos_anuales as $key=>$value) {            
            if ( $value['ingreso'] - $value['egreso'] > $maxBalance ) {
                $maxBalance= $value['ingreso'] - $value['egreso'];
                $mejorBalance['anio']= $key;
                $mejorBalance['total']= $maxBalance;
            }

            if($value['ingreso'] - $value['egreso'] < $minBalance ){
                $minBalance= $value['ingreso'] - $value['egreso'];
                $peorBalance['anio']= $key;
                $peorBalance['total']= $minBalance;
            }
        }
    
        $datos=collect();
        $datos->put('mejorBalance',$mejorBalance);
        $datos->put('peorBalance',$peorBalance);
        $datos->put('balanceHistorico',$misBalances);

        return view('balance.index',['datos'=>$datos]);

    }


    public function filtrado(){ 
        
        //para cargar select de años
        $misAños=Auth::user()->balances()->select(DB::raw('YEAR(fecha) año'))->groupBy('año')->get()->pluck('año') ;
        $meses=['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        
        return view('balance.filtrado',['mis_años'=>$misAños,'meses'=>$meses]); 
    }
    

    /*
        los IF request->ajax deberia agregarle mas adelante un else, para que retorne a 
        otra vista y no quede colgado por si alguien quiere acceder a esa ruta.
    */
    public function getPorAnio(Request $request,$año){

        if ($request->ajax()) {
            $aneo= DB::table('balances')->where('usuario_id','=',Auth::user()->id)
            ->select(DB::raw('YEAR(fecha) año'),'tipo',DB::raw('sum(monto) as suma')) 
            ->groupBy('año','tipo')->orderBy('año','asc')->get();
            
            $res=$aneo->where('año','=',$año);            
            $forma= $this->formatearArray($res);

            return response()->json($forma);
        }
    }

    public function getPorMes(Request $request,$mes){
        
        if ($request->ajax()) {          
            $mess= DB::table('balances')->where('usuario_id','=',Auth::user()->id)
            ->select(DB::raw('YEAR(fecha) año'),DB::raw('MONTH(fecha) mes'),'tipo',DB::raw('sum(monto) as suma')) 
            ->groupBy('año','mes','tipo')->orderBy('año','asc')->get();

            $res= $mess->where('mes','=',$mes);             
            $forma= $this->formatearArray($res);

            return response()->json($forma);
        }
    }

    public function getPorDia(Request $request,$desde,$hasta){
       
        if ($request->ajax()) {
            $dias= DB::table('balances')->where('usuario_id','=',Auth::user()->id)
            ->select('fecha','tipo',DB::raw('sum(monto) as suma')) 
            ->whereBetween('fecha',array($desde,$hasta))
            ->groupBy('fecha','tipo')->orderBy('fecha','asc')->get();

            $forma= $this->formatearArray2($dias);

            return response()->json($forma);
        }
    }


    public function getMensual(Request $request,$desde,$hasta){
        
        if ($request->ajax()) {
                  
            $mess= DB::table('balances')->where('usuario_id','=',Auth::user()->id)
            ->select(DB::raw('YEAR(fecha) año'),DB::raw('MONTH(fecha) mes'),'tipo',DB::raw('sum(monto) as suma')) 
            ->groupBy('año','mes','tipo')->orderBy('año','asc')->get();

            $res= $mess->where('año','>=',$desde)->where('año','<=',$hasta);
          
            $forma= $this->formatearArray3($res);
           
            return response()->json($forma);
        }
    }

    public function formatearArray($array){
        $forma= array();
        foreach ($array as $key) { 
            $forma[$key->año]=array('ingreso'=>0,'egreso'=>0);
        }    
        foreach ($array as $key) { //completo el array bien formateado
            $forma[$key->año][$key->tipo]+= $key->suma;
        } 
        return $forma;
    }

    public function formatearArray2($array){
        $forma= array();
        foreach ($array as $key) { 
            $forma[$key->fecha]=array('ingreso'=>0,'egreso'=>0);
        }    
        foreach ($array as $key) { //completo el array bien formateado
            $forma[$key->fecha][$key->tipo]+= $key->suma;
        } 
        return $forma;
    }

    public function formatearArray3($array){
        $forma= array();
        foreach ($array as $key) { 
            $forma[$key->año."-".$key->mes]=array('ingreso'=>0,'egreso'=>0);
        }    
        foreach ($array as $key) { //completo el array bien formateado
            $forma[$key->año."-".$key->mes][$key->tipo]+= $key->suma;
        } 
        return $forma;
    }


}
