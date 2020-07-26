<?php

namespace Sknmk\LibraryOperations\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $guarded = [];
    protected $fillable = ['name'];
    protected $table = 'author';
    public $timestamps = true;

    public function book()
    {
        return $this->hasMany('Sknmk\LibraryOperations\Models\Book');
    }
}
