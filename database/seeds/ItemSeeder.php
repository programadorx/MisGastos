<?php

use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $vector=['Alquiler','Sueldo','Aguinaldo','Agua','Luz','Gas','Internet','Celular','Cable','Cerveza','Fernet','Jugo','Tomate','Cebolla','Yerba','Azucar','Chorizo','Pollo','Asado','Pata y Muslo']; 

        foreach ($vector as $item) {
	        DB::table('items')->insert([
	            'nombre' => $item,
	        ]);

        }
    }
}
