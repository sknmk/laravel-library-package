<?php

namespace Sknmk\LibraryOperations\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $guarded = [];
    protected $fillable = ['name', 'author_id', 'description', 'label', 'status'];
    protected $table = 'book';
    public $timestamps = true;

    public function book_reader()
    {
        return $this->hasMany('Sknmk\LibraryOperations\Models\BookReader');
    }

    public function author()
    {
        return $this->belongsTo('Sknmk\LibraryOperations\Models\Author');
    }
}
