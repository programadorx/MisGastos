<?php

use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

	    $vector=['Hogar','Servicios','Electrodomesticos','Bebidas','Frutas y Verduras','Comestibles','Ocio','Vacaciones','Trabajo','Carnes','Enlatados'];
	        //
	    foreach ($vector as $categoria) {

	        DB::table('categorias')->insert([
	            'nombre' => $categoria,
	        ]);

	    }

    }
}
