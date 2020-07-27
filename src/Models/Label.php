<?php

namespace Sknmk\LibraryOperations\Models;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $guarded = [];
    protected $fillable = ['name', 'bit_value'];
    protected $table = 'label';
    public $timestamps = true;

    public function book()
    {
        return $this->belongsTo('Sknmk\LibraryOperations\Models\Book');
    }
}
