<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Author;
use Faker\Generator as Faker;

$factory->define(Author::class, function (Faker $faker) {
    return [
        //
         'title' => $faker->title,
         'firstName' => $faker->firstName,
        'surname' => $faker->lastName,
    ];
});
