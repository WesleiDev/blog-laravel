<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Autor::class, function (Faker $faker) {
    return [
        'nome' => $faker->firstName()
    ];
});
