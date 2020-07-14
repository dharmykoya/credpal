<?php

namespace App\Http\Controllers;

use App\Book;
use App\Repositories\BookRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class BookController extends Controller
{

    private $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listBooks(Request $request)
    {

        $filter= '';
        $filter_value = '';
        $filter2 = [];

        if ($request->has('title') && $request->query('title') != '') {
            $filter = 'title';
            $filter_value = $request->query('title');
        }

        if ($request->has('author') && $request->query('author') != '') {
            $filter2= $request->query('author');
            $filter2= explode(",",$filter2);
        }

        $allowed = array('title', 'authors');

        $sort = in_array($request->input('sortColumn'), $allowed) ? $request->query('sortColumn') : 'id';

        // default DESC
        $order = $request->input('sortDirection') === 'ASC' ? 'ASC' : 'DESC';


        $books = $this->bookRepository->getBooks($filter, $filter_value, $sort, $order, $filter2);
//
        if (!$books['status']) {
            return response()->json(['status' => 'failed', 'message'=> 'something went wrong'], 500);
        }

        return response()->json(['status' => 'success', 'data'=> $books['data']]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'author_id' => 'required|exists:authors,id',
            'isbn' => 'required|digits:13|unique:books',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=> 'failed', 'message' => $validator->errors()], 422);
        }

        $book = $this->bookRepository->createBook($request->all());

        if (!$book) {
            return response()->json(['status' => 'failed', 'message'=> 'something went wrong']);
        }

        return response()->json(['status' => 'success', 'data'=> $book]);
    }


}
