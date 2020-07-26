<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookReaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_reader', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('book');
            $table->foreignId('reader_id')->constrained('reader');
            $table->dateTime('borrow_date', 0);
            $table->dateTime('expected_return_date', 0)->nullable();
            $table->dateTime('return_date', 0)->nullable();
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_reader');
    }
}
