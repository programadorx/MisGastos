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
       
        $this->middleware('auth'); // solo puede acceder al controlador un usuario logueado

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        /*
            $todasCategorias= Categoria::All(); 
            Pero yo necesito recuperar las asociadas al usuario, las de la tabla pivot digamos
            y solo aquellas que el no haya borrado
        */
        $misCategorias=Auth::user()->categorias()->where('borrado','=',false)->orderBy('nombre','asc')->paginate(8); 

        return view('categoria.index',['misCategorias'=>$misCategorias]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){ 
       
        if($request->nombre==''){
            Session::flash('aviso','Ingrese un nombre correcto.'); 
            return Redirect::to('/categoria');
        }

        /*
        BORRADO pregunta si existia la relacion en la tabla intermedia y el usuario tenia borrada la
        categoria se la vuelve activar, caso contrario se fija que en el sistema en general si EXISTE
        la categoria, solamente se crea la relacion entre el usuario y esta, sino por ultimo se
        agrega la categoria a todo el sistema y se le asigna su relacion.
            
            Nota. Podria haber obviado gran parte de la estructura if-else para realizar
            esta logica, lo dejo asi para entenderlo el dia de mañana.
        */    
        $borrado= Auth::user()->categorias()->where('borrado','=',true)->where('nombre','=',$request->nombre)->count();

        if($borrado){
            Auth::user()->categorias()->where('borrado','=',true)->where('nombre','=',$request->nombre)->update(['borrado'=>false]); 

        }else{ 

            $existe= Categoria::where('nombre','=',$request->nombre)->first(); //Recupero objeto categoria o null

            if($existe != null){               
                $existe->users()->sync(Auth::user()->id,false);
                /*crea la asociacion,el false es para que no elimine las referencias de otros usuarios. 
                  dd("Ya existia esa categoria,entonces agregue la relacion ");
                */
            }else{        
                $categoria= new Categoria();
                $categoria->nombre=(ucwords (strtolower( $request->get('nombre') ) ) ); // pone en mayuscula cada palabra 
                $categoria->save();//se guarda en bd la nueva categoria
                $categoria->users()->sync(Auth::user()->id,false); // le asigno la relacion
               // dd("Nueva categoria y su asociacion creada");
            }
        }       
        Session::flash('guardar','Se agrego la categoria.'); 
        return Redirect::to('/categoria');
    }

   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        //el id que se recibe es el de la relacion, no el de la categoria.

        $cate_id=Auth::user()->categorias()->where('id','=',$id)->pluck('categoria_id');
        $resul= Auth::user()->clasificaciones()->where('categoria_id','=',$cate_id)->count();

        if($resul>0){
            Session::flash('aviso','La categoria posee items asociados,elimine las asociaciones');

        }else{
            Auth::user()->categorias()->where('id','=',$id)->update(['borrado'=>true]);         
            Session::flash('eliminar','Se Elimino la Categoria.'); 
        }
        
        return Redirect::to('/categoria');
    }
}
