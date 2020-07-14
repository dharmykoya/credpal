<?php


    namespace App\Repositories;

    use App\Book;
    use Illuminate\Database\Eloquent\Builder;


    class BookRepository
    {

        public function getBooks ($filter, $filter_value, $sort, $order, $filter2)
        {
//            dd($filter, $filter_value, $sort, $order, $filter2);
            try {
                if ($filter != '') {
                    $books =  Book::with('author:id,firstName,surname')
                        ->where([
                            [$filter, 'like', '%'.$filter_value.'%']
                        ])
//                        ->whereHas('author', function ($query) use ($filter2) {
//                            $query->whereIn('id', [1,2,3])->get();
//                        })
                        ->orderBy($sort, $order)
                        ->paginate(10);
                } else {
                    $books =  Book::with('author:id,firstName,surname')
                        ->orderBy($sort, $order)
                        ->paginate(10);
                }

                if (count($books) < 1) {
                    return ['status' => true, 'data' => 'no books available with the search'];
                }

                return ['status' => true, 'data' => $books];
            } catch (\Exception $error) {
//                dd($error->errorInfo);
                return ['status' => false, 'message' => $error->getMessage()];
            }
        }


        public  function createBook ($bookDetails) {
            try {
                return Book::create($bookDetails);
            } catch (\Exception $error) {
                return false;
            }
        }


    }
