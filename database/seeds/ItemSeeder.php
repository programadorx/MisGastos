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
        $vector=['Alquiler','Agua','Luz','Gas','Auriculares','Fernet','Tomate','Yerba']; 

        foreach ($vector as $item) {
	        DB::table('items')->insert([
	            'nombre' => $item,
	        ]);

        }
    }
}
