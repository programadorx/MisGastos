<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //
    protected $table='items'; //nombre de tabla

    protected $primaryKey='idItem';


    public $timestamps=false;
    //le indico que no se agreguen las dos columnas
    //de fecha de creacion y modificacion


    protected $fillable = [
        'nombre', 
    ];

    public function users(){

    	// items le pertenece a muchos usuarios {modelo, tabla_pivot, keyModeloPropio, KeyOtromodelo}
    	return $this->belongsToMany('App\User', 'item_user','item_id','usuario_id');
    }

    //agregue pa la 3era tabla
    public function clasificaciones(){

        //un item tiene muchas clasificaciones de categoria para cada usuario
        return $this->hasMany('App\MiClasificacion','item_id','idItem');
    }
}
