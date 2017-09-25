<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Item;
use Session;
use DB;

class ItemController extends Controller 
{
    public function __construct(){
        
        $this->middleware('auth');// solo puede acceder al controlador un usuario logueado

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        
        $misItems=Auth::user()->items()->where('borrado','=',false)->orderBy('nombre','asc')->Paginate(10); 
        //Recupero las de la tabla pivot solo las del usuario  
        return view('item.index',['misItems'=>$misItems]);
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
            return Redirect::to('/item');
        }

        $borrado= Auth::user()->items()->where('borrado','=',true)->where('nombre','=',$request->nombre)->count();

        if($borrado){
            Auth::user()->items()->where('borrado','=',true)->where('nombre','=',$request->nombre)->update(['borrado'=>false]); 

        }else{
            /*
                si ya existe el item en la bd, solo agrego la relacion del item
                con el usuario, caso contrario creo el item en la bd y lo relaciono

            */      
            $existe= Item::where('nombre','=',$request->nombre)->first();
            
            if($existe != null){
                //en caso de que exista la variable tiene un objeto item sino null
                $existe->users()->sync(Auth::user()->id,false); // crea la asociacion ,el false
                //es para que no elimine las referencias de otros usuarios. 
               // dd("Ya existia ese item, asique sume la relacion ");
            }else{
        
                $item= new Item();
                $item->nombre=(ucwords (strtolower( $request->get('nombre') ) ) ); // pone en mayuscula cada palabra

                $item->save(); //se guarda en bd la nueva item
                $item->users()->sync(Auth::user()->id,false); // le asigno la relacion
               // dd("Nueva categoria y su asociacion creada");
            }
        }       
        Session::flash('guardar','Se agrego el producto.'); 
        return Redirect::to('/item');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        //el id que se recibe es el de la relacion, no el de el item.

        $item_id=Auth::user()->items()->where('id','=',$id)->pluck('item_id');

        $resul= Auth::user()->clasificaciones()->where('item_id','=',$item_id)->count();
     
        if($resul>0){
            Session::flash('aviso','El item esta asociado a categorias,elimine las asociaciones');

        }else{
            Auth::user()->items()->where('id','=',$id)->update(['borrado'=>true]);         
            Session::flash('eliminar','Se Elimino el item.'); 

        }
        return Redirect::to('/item');  
    }

}
