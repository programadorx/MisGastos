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
        
        $misItems=Auth::user()->items()->orderBy('nombre','asc')->Paginate(4); 
        //Recupero las de la tabla pivot solo las del usuario  
        return view('item.index',['misItems'=>$misItems]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('item.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         //Si ya existe un item en la bd, solo agregare
        //la relacion N a N caso contrario, agrego y relaciono.

        $existe= Item::where('nombre','=',$request->nombre)->first();
        
        if($existe != null){
           //en caso de que exista la variable tiene un objeto item sino null
            $existe->users()->sync(Auth::user()->id,false); // crea la asociacion ,el false
            //es para que no elimine las referencias de otros usuarios. 

           // dd("Ya existia ese item, asique sume la relacion ");
        }else{
    
            $item= new Item();

            $item->nombre=$request->get('nombre'); 

            $item->save(); //se guarda en bd la nueva item

            $item->users()->sync(Auth::user()->id,false); // le asigno la relacion
           // dd("Nueva categoria y su asociacion creada");


        }
       
        Session::flash('guardar','Se agrego el producto.'); 
        return Redirect::to('/item');

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
