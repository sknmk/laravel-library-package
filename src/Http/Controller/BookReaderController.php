<?php

namespace Sknmk\LibraryOperations\Http\Controller;

use App\Http\Controllers\Controller,

    Illuminate\Http\Request,
    Sknmk\LibraryOperations\Models\BookReader;

/**
 * Class BookReaderController
 * @package Sknmk\LibraryOperations\Http\Controller
 */
class BookReaderController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function form()
    {
        return view('library::createBook');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function assign(Request $request)
    {
        $request->validate([
            'book_id' => ['required', 'exists:Sknmk\LibraryOperations\Models\Book,id',
                function ($attribute, $value, $fail) {
                    $isBorrowed = BookReader::where($attribute, $value)
                        ->whereNull('return_date')->get();
                    if (count($isBorrowed) > 0) {
                        $fail('Book is already borrowed.');
                    }
                }],
            'reader_id' => 'required|exists:Sknmk\LibraryOperations\Models\Reader,id',
            'expected_return_date' => 'date_format:Y-m-d'
        ]);

        $input = $request->all();
        $input["status"] = 1;
        $input["borrow_date"] = date("Y-m-d H:i:s", time());

        return BookReader::create($input);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function assignView()
    {
        return view('library::assignBook');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function return(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'return_date' => 'required|date_format:Y-m-d',
        ]);

        $input = $request->all();
        $input["status"] = 0;

        return BookReader::where('id', $input['id'])->update(['return_date' => $input['return_date'], 'status' => $input['status']]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function returnView()
    {
        return view('library::returnBook');
    }
}
