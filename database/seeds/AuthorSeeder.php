<?php

use Illuminate\Database\Seeder;
    use Illuminate\Support\Str;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        factory(\App\Author::class, 50)->create()->each(function ($author) {
            $author->books()->save(factory(App\Book::class)->make());
        });
    }
}
