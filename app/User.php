<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table='users';

    protected $primaryKey='id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function categorias(){

        // usuario tiene muchas categorias {modelo, tabla_pivot, keyModeloPropio, KeyOtromodelo}
        return $this->belongsToMany('App\Categoria', 'categoria_user','usuario_id','categoria_id');
    }

    public function items(){

        // usuario tiene muchos items {modelo, tabla_pivot, keyModeloPropio, KeyOtromodelo}
        return $this->belongsToMany('App\Item', 'item_user','usuario_id','item_id');
    }

    //agregue pa la 3era tabla
    public function clasificaciones(){

        //un usuario tiene muchas clasificaciones de sus items con categorias
        return $this->hasMany('App\MiClasificacion','usuario_id','id');
    }


    //relacion con balances
    public function balances(){
                                // la key del otro modelo, y el del mio
        return $this->hasMany('App\Balance','usuario_id','id');
    }
}
