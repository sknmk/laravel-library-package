<?php

namespace Sknmk\LibraryOperations\Http\Controller;

use App\Http\Controllers\Controller,

    Illuminate\Http\Request,
    Sknmk\LibraryOperations\Models\Reader;

/**
 * Class ReaderController
 * @package Sknmk\LibraryOperations\Http\Controller
 */
class ReaderController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function form()
    {
        return view('library::createReader');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email|unique:reader|max:75',
        ]);

        $input = $request->all();
        $input["status"] = 1;

        return Reader::create($input);
    }

    public function list()
    {
        return Reader::all();
    }

    public function listWithReader()
    {
        return Reader::with('book_reader.book')
            ->get();
    }
}
