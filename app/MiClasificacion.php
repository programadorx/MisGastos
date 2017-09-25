<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MiClasificacion extends Model
{
	/*
	en realidad seria una tabla pivote, pero como  relaciono 3 tablas,
    la voy a tratar como un modelo en si mismo, y le puse un nombre mas facil
    al modelo para simplicidad, pero hace referencia a la tabla categoria_item_user*/

    protected $table='categoria_item_user'; 
    protected $primaryKey='id';

    public $timestamps=false;
    /*
        le indico que no se agreguen las dos columnas
        de fecha de creacion y modificacion
    */

    protected $guarded = [
        'usuario_id',       
    ];

    protected $fillable = [      
        'categoria_id',
        'item_id', 
    ];

    public function user(){
    	// Estamos diciendo que Miclasificacion le pertenece a un user
    	
    	return $this->belongsTo('App\User','usuario_id');
    }

    public function categoria(){

        // clasificacion le pertenece a una categoria {modelo, tabla_pivot, keyModeloPropio, KeyOtromodelo}
        return $this->belongsTo('App\Categoria','categoria_id');
    }

    public function item(){

        // clasificacion le pertenece a un items {modelo, tabla_pivot, keyModeloPropio, KeyOtromodelo}
        return $this->belongsTo('App\Item','item_id');
    }

    public function balances(){
        // la key del otro modelo, y el del mio
        return $this->hasMany('App\Balance','cat_item_user','id');
    }
}
