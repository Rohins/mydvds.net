<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Book;
use App\Page;

use DB;

class BookController extends Controller
{
    /**
        This controller requires the user to be logged in
        in order to utilize its methods
    **/
    public function __construct()
    {
        $this->middleware('auth');
    }
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

    /**
     * Search all disks in all pages for a dvd
     * @param string $dvd
     * @return array
     **/
    public function searchDvd($dvd)
    {
        $dvd = strtolower($dvd);
        $allPages = DB::select('select book_id, number, disk1, disk2,  disk3, disk4 from pages where disk1 like "%'.$dvd.'%" or
                                              disk2 like "%'.$dvd.'%" or
                                              disk3 like "%'.$dvd.'%" or 
                                              disk4 like "%'.$dvd.'%"');

        $dvds = $this->filterPages($allPages, $dvd);
        return $dvds;
    }


    /**
     * Refactored helper function for checking all the 
     * disks for matches.
     * @param
     * @param string $dvd
     * @param array $dvds
     **/
    public function checkDisks($page, $dvd, $dvds)
    {
        $dvds = $this->checkDisk($page, $dvd, $dvds, 1);
        $dvds = $this->checkDisk($page, $dvd, $dvds, 2);
        $dvds = $this->checkDisk($page, $dvd, $dvds, 3);
        $dvds = $this->checkDisk($page, $dvd, $dvds, 4);
        return $dvds;
    }

    /**
     * Refactored helper function for checking individual
     * disks.
     * @param
     * @param string $dvd
     * @param array $dvds
     * @param int $number
     **/
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
    
    /**
     * Filters pages to include book name, slot number,
     * name of dvd, and page number.
     * @param array $allPages
     * @param string $dvd
     * @return array
     **/
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

    public function updateName(Request $request)
    {
        return $request;
        $book = Book::find($request->input('id'));
        $book->name = $request->input('name');
        $book->save();
    }

    public function updateNameGet($id, $name)
    {
        $book = Book::find($id);
        $book->name = $name;
        $book->save();
    }

    public function updateDiskGet($id, $disk_number, $name)
    {
        $page = Page::find($id);
        $disk = 'disk'.$disk_number;
        $page->$disk = $name;
        $page->save();
    }

    public function createNewBook($name)
    {
        $book = new Book;
        $book->name = $name;
        $book->save();

        for ($i = 1; $i <= 17; $i++) {
            $page = new Page;
            $page->book_id = $book->id;
            $page->number  = $i;
            $page->save();
        }
    }

}
