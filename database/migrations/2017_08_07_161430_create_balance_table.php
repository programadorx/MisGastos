<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('usuario_id')->unsigned();
            $table->foreign('usuario_id')->references('id')->on('users');

            $table->integer('cat_item_user')->unsigned();
            $table->foreign('cat_item_user')->references('id')->on('categoria_item_user');

            $table->date('fecha');
            $table->integer('cantidad');
            $table->decimal('precio_unitario',11,2);
            $table->decimal('monto', 11, 2);
            $table->string('descripcion')->nullable();
            $table->string('tipo',10);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('balances');
    }
}
