<?php

use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!\App\Models\Post::all()->count()){
            factory(\App\Models\Post::class, 2)->create(
                ['author_id' => 1,
                'category_id' => 1]
            );
        }
    }
}
