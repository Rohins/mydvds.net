<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Book;

use DB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Book::get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::find($id);
        $book->pages;
        return $book;
    }

    /**
     * Display the pages of a book, given a book id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getPagesById($id)
    {
        return Book::find($id)->pages;
    }

    public function searchDvd($dvd)
    {
        $allPages = DB::select('select book_id, number, disk1, disk2,  disk3, disk4 from pages where disk1 like "%'.$dvd.'%" or
                                              disk2 like "%'.$dvd.'%" or
                                              disk3 like "%'.$dvd.'%" or 
                                              disk4 like "%'.$dvd.'%"');

        $dvds = $this->filterPages($allPages, $dvd);
        return $dvds;
    }

    public function checkDisks($page, $dvd, $dvds)
    {
        $dvds = $this->checkDisk($page, $dvd, $dvds, 1);
        $dvds = $this->checkDisk($page, $dvd, $dvds, 2);
        $dvds = $this->checkDisk($page, $dvd, $dvds, 3);
        $dvds = $this->checkDisk($page, $dvd, $dvds, 4);
        return $dvds;
    }

    public function checkDisk($page, $dvd, $dvds, $number)
    {
        $diskNumber = 'disk'.$number;
        $disk = $page->$diskNumber;
        if (strpos(strtolower($disk), $dvd) !== false) {
            $dvds[] = array("book" => Book::find($page->book_id)->name,
                            "slot" => "$number",
                            "name" => $disk, 
                            "page" => $page->number);
        }
        return $dvds;
    }
    
    public function filterPages($allPages, $dvd)
    {
        $dvds = [];
        foreach($allPages as $page) {
            $dvds = $this->checkDisks($page, $dvd, $dvds);
        }

        return $dvds;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
