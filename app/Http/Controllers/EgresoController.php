<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Balance;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;

class EgresoController extends Controller
{
    
    public function __construct(){
        // solo puede acceder al controlador un usuario logueado
        $this->middleware('auth');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=Auth::user();
        $misEgresos=Auth::user()->balances()->where('tipo','egreso')->orderBy('fecha','desc')->paginate(8);         
 
        $misClasificaciones=$user->clasificaciones->groupBy('categoria.nombre');

        return view('egreso.index',['misEgresos'=>$misEgresos,'misClasificaciones'=>$misClasificaciones]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nuevoBalance= new Balance();

        $nuevoBalance->usuario_id= Auth::user()->id;
        $nuevoBalance->tipo='egreso';

        $nuevoBalance->cat_item_user=$request->clasificacion;
        $nuevoBalance->fecha=$request->fecha;
        $nuevoBalance->cantidad=$request->cantidad;
        $nuevoBalance->precio_unitario=$request->precio_unitario;
       
       // $nuevoBalance->monto=$request->monto; lo calculo aca por si falla el calculo ej jquery del lado del cliente

        $nuevoBalance->monto=($request->cantidad * $request->precio_unitario);

        $nuevoBalance->descripcion=$request->descripcion;

        $nuevoBalance->save();

   
        Session::flash('guardar','Egreso creado con exito');
        return Redirect::to('egreso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function estadisticas()
    {
        //para cargar select de años
        $misAños=Auth::user()->balances()->select(DB::raw('YEAR(fecha) año'))->groupBy('año')->get()->pluck('año') ;
        $meses=['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        $miscategorias=Auth::user()->categorias()->get();
        $misClasificaciones=Auth::user()->clasificaciones->groupBy('categoria.nombre');
      
        return view('egreso.estadisticas',['mis_años'=>$misAños,'meses'=>$meses,'catego'=>$miscategorias,'misClasificaciones'=>$misClasificaciones]);
    }

    public function getPorDia(Request $request,$desde,$hasta){
       if ($request->ajax()) {
            $consulta= DB::table('balances')->where('usuario_id','=',Auth::user()->id)
            ->where('tipo','=','egreso')
            ->select('fecha','tipo',DB::raw('sum(monto) as suma')) 
            ->whereBetween('fecha',array($desde,$hasta))
            ->groupBy('fecha','tipo')->orderBy('fecha','asc')->get();

            $dia=$consulta->pluck('fecha');
            $suma=$consulta->pluck('suma');

            return response()->json(array('dia'=>$dia,'suma'=>$suma));
        }
    }

    public function getMensual(Request $request,$desde,$hasta){
        if ($request->ajax()) {
          
            $consulta= DB::table('balances')->where('usuario_id','=',Auth::user()->id)
            ->where('tipo','=','egreso')
            ->select(DB::raw('YEAR(fecha) año'),DB::raw('MONTH(fecha) mes'),'tipo',DB::raw('sum(monto) as suma')) 
            ->groupBy('año','mes','tipo')->orderBy('año','asc')->get();

            $res= $consulta->where('año','>=',$desde)->where('año','<=',$hasta);

            $dia=array();
            foreach ($res as $key => $value) {
                array_push($dia, $value->año."-".$value->mes); 
            }
            $suma=$res->pluck('suma');

            
            return response()->json(array('dia'=>$dia,'suma'=>$suma));
        }
    }

    public function getPorAnio(Request $request,$año){

        if ($request->ajax()) {
            $aneo= DB::table('balances')->where('usuario_id','=',Auth::user()->id)
            ->where('tipo','=','egreso')
            ->select(DB::raw('YEAR(fecha) año'),'tipo',DB::raw('sum(monto) as suma')) 
            ->groupBy('año','tipo')->orderBy('año','asc')->get();
            
            $res=$aneo->where('año','=',$año);            
            
            $dia=$res->pluck('año');
            $suma=$res->pluck('suma');

            return response()->json(array('dia'=>$dia,'suma'=>$suma));
        }
    }

    public function getPorMes(Request $request,$mes){
        if ($request->ajax()) {
          
            $mess= DB::table('balances')->where('usuario_id','=',Auth::user()->id)
            ->where('tipo','=','egreso')
            ->select(DB::raw('YEAR(fecha) año'),DB::raw('MONTH(fecha) mes'),'tipo',DB::raw('sum(monto) as suma')) 
            ->groupBy('año','mes','tipo')->orderBy('año','asc')->get();

            $res= $mess->where('mes','=',$mes);             
            $dia=$res->pluck('año');
            $suma=$res->pluck('suma');

            return response()->json(array('dia'=>$dia,'suma'=>$suma));
        }
    }

   public function getPorCategoria(Request $request,$idCategoria){
        if ($request->ajax()) {
          
            $consulta= DB::table('balances as b')->where('b.usuario_id','=',Auth::user()->id)
            ->where('b.tipo','=','egreso')
            ->join('categoria_item_user as ciu','b.cat_item_user','=','ciu.id')
            ->where('ciu.categoria_id','=',$idCategoria)
            ->select(DB::raw('YEAR(fecha) año'),DB::raw('MONTH(fecha) mes'),'tipo',DB::raw('sum(monto) as suma')) 
            ->groupBy('año','mes','tipo')->orderBy('año','asc')->get();

            $dia=array();
            foreach ($consulta as $key => $value) {
                array_push($dia, $value->año."-".$value->mes); 
            }
            $suma=$consulta->pluck('suma');           

            return response()->json(array('dia'=>$dia,'suma'=>$suma));
        }
    }

   public function getPorProducto(Request $request,$idProducto,$tipo){
        if ($request->ajax()) {
          
            if ($tipo=='todo') {
                $consulta= DB::table('balances')->where('usuario_id','=',Auth::user()->id)
                ->where('tipo','=','egreso')
                ->where('cat_item_user','=',$idProducto)
                ->select(DB::raw('YEAR(fecha) año'),DB::raw('MONTH(fecha) mes'),'tipo',DB::raw('sum(monto) as suma')) 
                ->groupBy('año','mes','tipo')->orderBy('año','asc')->get();       
                
                $dia=array();
                foreach ($consulta as $key => $value) {
                    array_push($dia, $value->año."-".$value->mes); 
                }
                $suma=$consulta->pluck('suma'); 
            
            }else{ //llega tipo evolucion
                $consulta= DB::table('balances')->where('usuario_id','=',Auth::user()->id)
                ->where('tipo','=','egreso')
                ->where('cat_item_user','=',$idProducto)->orderBy('fecha','asc')->get();               
                $dia=$consulta->pluck('fecha');
                $suma=$consulta->pluck('precio_unitario');              
            }       

            return response()->json(array('dia'=>$dia,'suma'=>$suma));
        }
    }
}
