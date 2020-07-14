<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    //
    protected $guarded = [];


    public function books()
    {
        return $this->hasMany('App\Book');
    }
}
