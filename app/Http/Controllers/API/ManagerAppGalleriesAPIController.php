<?php

namespace App\Http\Controllers\API\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

USE DB;
class ManagerAppGalleriesAPIController extends Controller
{
    function index(Request $request)
    {

        $manager_id = $request->id;

        $faq = DB::table('galleries')
        ->leftjoin('markets','markets.id','=','galleries.market_id')
        ->leftjoin('user_markets','user_markets.market_id','=','markets.id')
        ->select('galleries.id','galleries.description',
        'galleries.updated_at','markets.name as market_name')
          ->where('user_markets.user_id','=',$manager_id)
        ->get();

        return $this->sendResponse($faq->toArray(), 'Faqs retrieved successfully');
   
    }
}
