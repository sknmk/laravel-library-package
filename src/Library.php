<?php

namespace SerkanMertKaptan\LibraryOperations;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Library
{

    const BOOK_TABLE = 'book';

    public function getBooks(Request $request)
    {
        return DB::table(self::BOOK_TABLE)->where('id', $request->input('id'))->get();
    }

    public function getBooksBatch()
    {
        return DB::table(self::BOOK_TABLE)->get();
    }

    public function createBook(Request $request)
    {
        $this->validateBook($request);

        DB::table(self::BOOK_TABLE)->insert([
            'name' => $request->input('name'),
            'authorId' => $request->input('author'),
            'label' => $request->input('label'),
            'description' => $request->input('description'),
            'insertDate' => date("Y-m-d H:i:s", time())
        ]);
    }

    private function validateBook(Request $request)
    {
        return $request->validate([
            'name' => 'required|unique:book|max:75',
            'authorId' => 'required',
            'label' => $request->input('label'),
            'description' => $request->input('description'),
            'insertDate' => date("Y-m-d H:i:s", time())
        ]);
    }

    public function createUser(Request $request)
    {
        $this->validateUser($request);
        DB::table('user')->insert([
            'name' => $request->input('name'),
            'insertDate' => date("Y-m-d H:i:s", time())
        ]);
    }

    public function validateUser(Request $request)
    {
        return $request->validate([
            'name' => 'required|unique:user|max:50',
            'body' => 'required',
        ]);
    }

}
