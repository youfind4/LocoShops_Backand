<?php

namespace App\Http\Controllers\API\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

USE DB;
class ManagerAppFavoritesAPIController extends Controller
{
    function index(Request $request)
    {

        $manager_id = $request->id;

        $faq = DB::table('favorites')
        ->leftjoin('products','products.id','=','favorites.product_id')
        ->leftjoin('user_markets','user_markets.market_id','=','products.market_id')
        ->leftjoin('favorite_options','favorite_options.favorite_id','=','favorites.id')
        ->leftjoin('options','options.id','=','favorite_options.option_id')
        ->select('favorites.id','favorites.product_id','favorites.user_id','favorites.updated_at',
        'products.name as product_name','options.name as option')
          ->where('user_markets.user_id','=',$manager_id)
        ->get();

        return $this->sendResponse($faq->toArray(), 'Faqs retrieved successfully');
   
    }
	    function delete(Request $request){
        $fav_id = $request->id;

        $delete = DB::table('favorites')->where('id','=', $fav_id)->delete();

        return $this->sendResponse('deleted', 'data deleted successfully');;

    }
}
