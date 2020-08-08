<?php

namespace App\Http\Controllers\API\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

USE DB;
class ManagerAppMarketReviewsAPIController extends Controller
{
    function index(Request $request)
    {

        $manager_id = $request->id;

        $faq = DB::table('market_reviews')
        ->leftjoin('markets','markets.id','=','market_reviews.market_id')
        ->leftjoin('user_markets','user_markets.market_id','=','markets.id')
        ->leftjoin('users','users.id','=','market_reviews.user_id')
        ->select('market_reviews.id','market_reviews.review','market_reviews.rate',
        'market_reviews.updated_at','markets.id as market_id','markets.name as market_name',
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
        $market_id = $request->market_id;
        $user_id = $request->user_id;
       
        $update = DB::table('market_reviews')
            ->where('id', $id)
            ->update([
                'review' => $review, 'rate' => $rate,
                'market_id' => $market_id, 'user_id' => $user_id,
                ]);

        return $this->sendResponse($update, 'Market Reviews Updated Succesfully');
    }
	    function fetchuserslist(){
        $faq = DB::table('users')
                ->select('users.id','users.name as user_name')->get();
    return $this->sendResponse($faq->toArray(), 'Users retrieved successfully');

    }
	    function fetchmarketslist(){
        $faq = DB::table('markets')
                ->select('markets.id','markets.name as market_name')->get();
    return $this->sendResponse($faq->toArray(), 'Markets retrieved successfully');

    }
}
