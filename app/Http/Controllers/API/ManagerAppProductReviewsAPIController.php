<?php

namespace App\Http\Controllers\API\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

USE DB;
class ManagerAppProductReviewsAPIController extends Controller
{
    function index(Request $request)
    {

        $manager_id = $request->id;

        $faq = DB::table('product_reviews')
        ->leftjoin('products','products.id','=','product_reviews.product_id')
        ->leftjoin('user_markets','user_markets.market_id','=','products.market_id')
        ->leftjoin('users','users.id','=','product_reviews.user_id')
        ->select('product_reviews.id','product_reviews.review','product_reviews.rate',
        'product_reviews.updated_at','products.id as product_id','products.name as product_name',
				 'users.id as user_id','users.name as username')
          ->where('user_markets.user_id','=',$manager_id)
        ->get();

        return $this->sendResponse($faq->toArray(), 'Faqs retrieved successfully');
   
    }
        function update(Request $request)
    {

        $id = $request->id;
        $review = $request->review;
        $rate = $request->rate;
        $product_id = $request->product_id;
        $user_id = $request->user_id;
       
        $update = DB::table('product_reviews')
            ->where('id', $id)
            ->update([
                'review' => $review, 'rate' => $rate,
                'product_id' => $product_id, 'user_id' => $user_id,
                ]);

        return $this->sendResponse($update, 'Product Reviews Updated Succesfully');
    }
}
