<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(TagTableSeedee::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(AuthorTableSeeder::class);
        $this->call(PostTableSeeder::class);
    }
}
