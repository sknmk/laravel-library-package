<?php

namespace SerkanMertKaptan\LibraryOperations;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Book
{
    public function test($param)
    {
        return dd($param);
    }

    public function get(Request $request)
    {
        return DB::table('book')->where('id', $request->input('id'))->get();
    }

    public function getBatch()
    {
        return DB::table('book')->get();
    }

    public function create(Request $request)
    {
        $this->validate($request);

        DB::table('book')->insert([
            'name' => $request->input('name'),
            'authorId' => $request->input('author'),
            'label' => $request->input('label'),
            'description' => $request->input('description'),
            'insertDate' => date("Y-m-d H:i:s", time())
        ]);
    }

    private function validate(Request $request) {
        return $request->validate([
            'name' => 'required|unique:book|max:75',
            'authorId' => 'required',
            'label' => $request->input('label'),
            'description' => $request->input('description'),
            'insertDate' => date("Y-m-d H:i:s", time())
        ]);
    }

}
