<?php

use Illuminate\Database\Seeder;

class TagTableSeedee extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!\App\Models\Tag::all()->count()){
            factory(\App\Models\Tag::class, 3)->create();
        }
    }
}
