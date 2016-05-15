<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function pages ()
    {
        return $this->hasMany('App\Page');
    }

    public static function CreateBook ()
    {
        $book = new Book;
        $book->save();

        for ($i = 1; $i <= 17; $i++) {
            $page = new Page;
            $page->book_id = $book->id;
            $page->number  = $i;
            $page->save();
        }

        return $book;
    }
}
