<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    //
    protected $table='categorias'; //nombre de tabla

    protected $primaryKey='idCategoria';


    public $timestamps=false;
    //le indico que no se agreguen las dos columnas
    //de fecha de creacion y modificacion


    protected $fillable = [
        'nombre', 
    ];

    public function users(){

    	// Categoria tiene muchos usuarios {modelo, tabla_pivot, keyModeloPropio, KeyOtromodelo}
    	return $this->belongsToMany('App\User', 'categoria_user','categoria_id','usuario_id');
    }

   
        //agregue pa la 3era tabla
    public function clasificaciones(){

        //una categoria tiene muchas clasificaciones de sus items con usuarios
        return $this->hasMany('App\MiClasificacion','categoria_id','idCategoria');
    }
}
