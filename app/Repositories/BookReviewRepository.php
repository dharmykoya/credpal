<?php


    namespace App\Repositories;
    use App\BookReview;


    class BookReviewRepository
    {

        public  function createReview ($details) {
            try {
                $bookReview = BookReview::create($details);

               $bookReview->user;

                return ['status' => true, 'data' => $bookReview];
            } catch (\Exception $error) {
                return ['status' => false, 'data' => 'something went wrong'];
            }
        }
    }
