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
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ClasificacionController extends Controller
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

        $misItems=Auth::user()->items()->where('borrado','=',false)->get(); 
     
        //$misClasificaciones=Auth::user()->clasificaciones->sortBy('categoria.nombre')->groupBy('categoria.nombre'); original

        // utilize una funcion para crear la paginacion para una "coleccion"
       $prueba=Auth::user()->clasificaciones->sortBy('categoria.nombre')->groupBy('categoria.nombre');
       $misClasificaciones = $this->paginate($prueba);
       $misClasificaciones->setPath('/clasificacion');
     
        // Debo pasar a la vista mis categorias sin ninguna asociasiones echas aun, asi las puede rellenar.        
        $cate_asociadas= Auth::user()->clasificaciones()->pluck('categoria_id')->toArray();
       
        $misCat_sinClasi= Auth::user()->categorias()->where('borrado','=',false)->whereNotIn('categoria_id', $cate_asociadas)->get();

        return view('clasificacion.index',['agrupados'=>$misClasificaciones,'misItems'=>$misItems,'sinClasificacion'=>$misCat_sinClasi]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $miId=Auth::user()->id;
        $categ=$request->get('categoria'); 
        $item=$request->get('item');

        $existe=DB::table('categoria_item_user as ciu')->where('usuario_id','=',$miId)
        ->where('categoria_id','=',$categ)->where('item_id','=',$item)->first();

        if ($existe != null) {
            Session::flash('aviso','Ese item ya pertenece a esa categoria');
            return Redirect::to('clasificacion');          
        } else {

            $nueva= new MiClasificacion();
            $nueva->usuario_id=$miId;
            $nueva->categoria_id=$categ;
            $nueva->item_id=$item;
            $nueva->save();

            Session::flash('guardar','Se agrego el item a la categoria.');
            return Redirect::to('clasificacion');
        }        
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        //Me llega el id, te la tabla que representa toda la asociacion
        //[ --> id <--, usuario_id,categoria_id,item_id]
        try {
            $clasi=MiClasificacion::find($id);
            $clasi->delete();
            Session::flash('eliminar','Se elimino el item de la categoria');          
        } catch (\Exception $e) {
           Session::flash('aviso','Tiene balances cargados. Debe eliminarlos previamente.');
        }

        return Redirect::to('clasificacion');
    }

    public function paginate($items, $perPage = 8, $page = null, $options = []) {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
