<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCategoriaItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoria_item_user', function (Blueprint $table) {
            $table->increments('id')->references('cat_item_user')->on('balances')->onDelete('restrict');
            $table->integer('usuario_id')->unsigned();
            $table->integer('categoria_id')->unsigned();
            $table->integer('item_id')->unsigned();

            $table->unique(['usuario_id','categoria_id','item_id']);
            
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->foreign('categoria_id')->references('idCategoria')->on('categorias');   
            $table->foreign('item_id')->references('idItem')->on('items');         

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() 
    {
        Schema::dropIfExists('categoria_item_user');
    }
}
