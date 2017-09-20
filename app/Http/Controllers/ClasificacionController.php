<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\MiClasificacion;
use App\Categoria;
use DB;
use Session;

class ClasificacionController extends Controller
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
        $idUser=Auth::user()->id; 
 
        $misItems=Auth::user()->items;      
     
        $misClasificaciones=Auth::user()->clasificaciones->sortBy('categoria.nombre')->groupBy('categoria.nombre'); 
        
        //*********************************
        // Debo pasar a la vista mis categorias sin ninguna asociasiones echas aun, asi las puede rellenar.
        
        $misCat_sinClasi= Auth::user()->categorias()->doesntHave('clasificaciones')->get();
        
        return view('clasificacion.index',['agrupados'=>$misClasificaciones,'misItems'=>$misItems,'sinClasificacion'=>$misCat_sinClasi]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $misCategorias=Auth::user()->categorias; 
        $misItems=Auth::user()->items;

        return view('clasificacion.create',['misCategorias'=>$misCategorias,'misItems'=>$misItems]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $miId=Auth::user()->id;
        $categ=$request->get('categoria'); 
        $item=$request->get('item');

        $existe=DB::table('categoria_item_user as ciu')->where('usuario_id','=',$miId)
        ->where('categoria_id','=',$categ)
        ->where('item_id','=',$item)
        ->first();

        if ($existe != null) {
            Session::flash('aviso','Ese item ya pertenece a esa categoria');
            return Redirect::to('clasificacion');
          // dd("Ya existe ese item asignado a esa categoria, debo informar con un flash o no hacer nada");
        } else {

            $nueva= new MiClasificacion();

            $nueva->usuario_id=$miId;
            $nueva->categoria_id=$categ;
            $nueva->item_id=$item;
            $nueva->save();

            Session::flash('guardar','Se agrego el item a la categoria.');
            return Redirect::to('clasificacion');
        }
        
      //  dd('categoria id es ..'.$categ.' y item '.$item);
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
        //Me llega el id, te la tabla que representa toda la asociacion
        //[ --> id <--, usuario_id,categoria_id,item_id]
      
        $clasi=MiClasificacion::find($id);
        $clasi->delete();

        Session::flash('eliminar','Se elimino el item de la categoria');
        return Redirect::to('clasificacion');
    }
}
