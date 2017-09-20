<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Categoria;
use Session;
use DB;
class CategoriaController extends Controller
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
        //$todasCategorias= Categoria::All();
        //dd($todasCategorias);
       
        $misCategorias=Auth::user()->categorias()->orderBy('nombre','asc')->paginate(8); 
        //Recupero las de la tabla pivot solo las del usuario 
       
       // return response()->json($misCategorias);
        return view('categoria.index',['misCategorias'=>$misCategorias]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Si ya existe una categoria en la bd, solo agregare
        //la relacion N a N caso contrario, agrego y relaciono.

        $existe= Categoria::where('nombre','=',$request->nombre)->first();
        
        if($existe != null){
           //en caso de que exista la variable tiene un objeto categoria sino null
            $existe->users()->sync(Auth::user()->id,false); // crea la asociacion ,el false
            //es para que no elimine las referencias de otros usuarios. 

           // dd("Ya existia esa categoria, asique sume la relacion ");
        }else{
    
            $categoria= new Categoria();

            $categoria->nombre=$request->get('nombre'); 

            $categoria->save(); //se guarda en bd la nueva categoria

            $categoria->users()->sync(Auth::user()->id,false); // le asigno la relacion
           // dd("Nueva categoria y su asociacion creada");
        }
       
        Session::flash('guardar','Se agrego la categoria.'); 
        return Redirect::to('/categoria');

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
}
