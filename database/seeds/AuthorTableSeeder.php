<?php

use Illuminate\Database\Seeder;

class AuthorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!\App\Models\Author::all()->count()){
            factory(\App\Models\Author::class, 5)->create();
        }
    }
}
