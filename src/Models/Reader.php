<?php

namespace Sknmk\LibraryOperations\Models;

use Illuminate\Database\Eloquent\Model;

class Reader extends Model
{
    protected $guarded = [];
    protected $fillable = ['name', 'email', 'status'];
    protected $table = 'reader';
    public $timestamps = true;

    public function book_reader()
    {
        return $this->hasMany('Sknmk\LibraryOperations\Models\BookReader');
    }
}
