<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    //
    protected $table='balances'; //nombre de tabla

    protected $primaryKey='id';


    public $timestamps=true;
    //le indico que se agreguen las dos columnas
    //de fecha de creacion y modificacion


    protected $guarded = [
	    'id',
	    'usuario_id',
	    'tipo',
    ];
 
 	//filliable son los datos que pueden ingresarse por form, de forma
 	//masiva
    protected $fillable = [
        'cat_item_user',
        'fecha',
        'cantidad',
        'precio_unitario',
        'monto',
        'descripcion',
    ];

   public function user(){
    	// balance le pertenece a un usuario 
    	return $this->belongsTo('App\User','usuario_id');
    }

    public function clasificacion(){
        //de aca puedo recuperar la clasificacion
        // pedirle el nombre a la categoria y item 
        return $this->belongsTo('App\MiClasificacion','cat_item_user','id');
    }
	
}
