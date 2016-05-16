<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Database\Capsule\Manager as Capsule;

class ImportController extends Controller
{
    private function connectLegacy() 
    {
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver'   => 'mysql',
            'host'     => 'localhost',
            'database' => 'legacy_dvds',
            'username' => 'root',
            'password' => 'bumpin1n!',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => ''
        ]);
        $capsule->setAsGlobal();
    }

    private function connectCurrent() 
    {
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver'   => 'mysql',
            'host'     => 'localhost',
            'database' => 'grandpa_dvds',
            'username' => 'root',
            'password' => 'bumpin1n!',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => ''
        ]);
        $capsule->setAsGlobal();
    }

    private function deleteCurrentDatabase()
    {
        $this->connectCurrent();
        Capsule::table('pages')->delete();
        Capsule::table('books')->delete();
    }

    public function importDatabase()
    {
        $this->deleteCurrentDatabase();

        $this->connectLegacy();

        $books = Capsule::select("select * from books");
        $pages = Capsule::select("select * from pages");
        $disks = Capsule::select("select * from disks");

        $this->loadBooks($books);
        $this->loadPages($pages);
        $this->loadDisks($disks);

        return $books;
    }

    private function loadBooks($books)
    {
        $this->connectCurrent(); 
        foreach ($books as $book) {
            Capsule::table("books")->insert([
                'id'   => $book->id, 
                'name' => $book->name
            ]);
        }
    }

    private function loadPages($pages)
    {
        $this->connectCurrent();
        foreach ($pages as $page) {
            Capsule::table("pages")->insert([
                'id'      => $page->id,
                'number'  => $page->page_number,
                'book_id' => $page->book_id
            ]);
        }
    }

    private function loadDisks($disks)
    {
        $this->connectCurrent();
        foreach ($disks as $disk) {
            $this->updatePageWithDisk($disk);
        }
    }

    private function updatePageWithDisk($disk)
    {
        $disk_number = "disk" . $disk->slot; 
        Capsule::table("pages")
            ->where('id', '=', $disk->page_id)
            ->update([
            $disk_number => $disk->name
        ]);
    }
}
