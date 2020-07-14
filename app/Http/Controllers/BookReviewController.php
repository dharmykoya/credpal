<?php

namespace App\Http\Controllers;

use App\Book;
use App\Repositories\BookReviewRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class BookReviewController extends Controller
{
    //

    private $bookReviewRepository;

    public function __construct(BookReviewRepository $bookReviewRepository)
    {
        $this->bookReviewRepository = $bookReviewRepository;
    }

    public function store (Request $request) {

        $book_id = $request->route('id');
        $book = Book::find($book_id);

        if (!$book) {
            return response()->json(['status'=> 'failed', 'message' => 'book not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'review' => 'required|numeric|min:1|max:10',
            'comment' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=> 'failed', 'message' => $validator->errors()], 422);
        }

        $reviewData['review'] = $request->input('review');
        $reviewData['comment'] = $request->input('comment');
        $reviewData['user_id'] = Auth::id();
        $reviewData['book_id'] = $book_id;

        $review = $this->bookReviewRepository->createReview($reviewData);

        if (!$review['status']) {
            return response()->json(['status' => 'failed', 'message'=> 'something went wrong'], 500);
        }

        $user = $review['data']->user(['name', 'id']);

        return response()->json(['status' => 'success', 'data'=> ['book' => $review['data']]]);
    }
}
