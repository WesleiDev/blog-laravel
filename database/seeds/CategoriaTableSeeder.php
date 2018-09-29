<?php

use Illuminate\Database\Seeder;

class CategoriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!\App\Models\Categoria::all()->count()){
            factory(\App\Models\Categoria::class, 5)->create();
        }
    }
}
