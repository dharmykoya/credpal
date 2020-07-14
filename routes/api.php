<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/', function (Request $request) {
    return response()->json(['status' => 'success', 'message'=> 'welcome to credpal test solution']);
});

Route::post('/register', 'AuthController@register');

Route::post('/login', 'AuthController@login')->name('login');

Route::get('/login', function (Request $request) {
    return response()->json(['status' => 'failed', 'message' => 'Please login to continue'], 401);
})->name('login');


//    http://127.0.0.1:8000/api/books?page=2&sortColumn=title&sortDirection=DESC&title=dam&author=123
Route::get('/books', 'BookController@listBooks');


Route::middleware('auth:api')->group(function () {
    // our routes to be protected will go in here
    Route::post('/books', 'BookController@store')->middleware('auth.admin');
    Route::post('/books/{id}/reviews', 'BookController@createReview');
    Route::post('/books/{id}/reviews', 'BookReviewController@store');
});



