<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookReview extends Model
{
    //

    protected $guarded = [];
    protected $hidden = [
        'user_id', 'book_id', 'created_at', 'updated_at',
    ];

    public function user () {
        return $this->belongsTo('App\User');
    }
}
