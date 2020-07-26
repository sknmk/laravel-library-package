<?php

namespace Sknmk\LibraryOperations\Models;

use Illuminate\Database\Eloquent\Model;

class BookReader extends Model
{
    protected $guarded = [];
    protected $fillable = ['book_id', 'reader_id', 'borrow_date', 'expected_return_date', 'return_date', 'status'];
    protected $table = 'book_reader';
    public $timestamps = true;

    public function reader()
    {
        return $this->belongsTo('Sknmk\LibraryOperations\Models\Reader');
    }

    public function book()
    {
        return $this->belongsTo('Sknmk\LibraryOperations\Models\Book');
    }
}
