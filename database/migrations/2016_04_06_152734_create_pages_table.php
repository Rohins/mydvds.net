<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('number')->unsigned();
            $table->integer('book_id')->unsigned()->unique();
            $table->string('disk1');
            $table->string('disk2');
            $table->string('disk3');
            $table->string('disk4');
            $table->timestamps();

            $table->foreign('book_id')
                  ->references('id')
                  ->on('books');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pages');
    }
}
