<?php

use Illuminate\Database\Seeder;

class AutorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!\App\Models\Autor::all()->count()){
            factory(\App\Models\Autor::class, 5)->create();
        }
    }
}
