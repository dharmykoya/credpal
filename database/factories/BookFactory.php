<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use Faker\Generator as Faker;
    use Illuminate\Support\Str;

    $factory->define(Book::class, function (Faker $faker) {
    return [
        //
        'title' => $faker->sentence(4),
        'description' => $faker->sentence(12),
        'ISBN' => Str::random(13),
        'author_id' => $faker->numberBetween(1,20)
    ];
});
