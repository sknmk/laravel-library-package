<?php

namespace Sknmk\LibraryOperations\Http\Controller;

use App\Http\Controllers\Controller,

    Illuminate\Http\Request,
    Sknmk\LibraryOperations\Models\Book,
    Sknmk\LibraryOperations\Models\Label;
use Sknmk\LibraryOperations\Models\Author;

/**
 * Class BookController
 * @package Sknmk\LibraryOperations\Http\Controller
 */
class BookController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function form()
    {
        return view('library::createBook', ["authors" => Author::all(), "labels" => Label::all()]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'author_id' => 'required|integer',
            'description' => 'required',
            'label' => 'required|integer'
        ]);

        $input = $request->all();
        $input["status"] = 1;

        return Book::create($input);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detailView()
    {
        return view('library::detailBook', ['labels' => Label::all()]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function list(Request $request)
    {
        $list = Book::with('author');

        if ($request instanceof Request) {
            $request->validate([
                'author_id' => 'nullable|exists:Sknmk\LibraryOperations\Models\Author,id',
                'label' => 'nullable|integer',
            ]);

            $input = $request->all();
            if (!empty($input["author_id"])) {
                $list->where('author_id', $input["author_id"]);
            }
            if (!empty($input["label"])) {
                $list->whereRaw('label & ' . $input["label"]);
            }
        }

        return $list->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function listWithReader()
    {
        return Book::with('author', 'book_reader')
            ->get();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listView()
    {
        return view('library::listBook', ["authors" => Author::all(), "labels" => Label::all()]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function detail($id)
    {
        return Book::where('id', $id)
            ->with('author', 'book_reader.reader')
            ->first();
    }
}
