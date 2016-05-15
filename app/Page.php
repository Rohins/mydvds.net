<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public function book ()
    {
        return $this->belongsTo('App\Book');
    }

    public static function search ($movie_title)
    {
        $pages = Page::where('disk1', 'like', '%'.$movie_title.'%')
                   ->orWhere('disk2', 'like', '%'.$movie_title.'%')
                   ->orWhere('disk3', 'like', '%'.$movie_title.'%')
                   ->orWhere('disk4', 'like', '%'.$movie_title.'%')
                   ->get();
        return $pages;
    }
}
