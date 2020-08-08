<?php

namespace App\Http\Controllers\API\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
class ManagerAppEarningsAPIController extends Controller
{
    function index(Request $request)
    {
        $manager_id = $request->manager_id;
        $earnings = DB::table('earnings')
        ->leftjoin('markets','markets.id','=','earnings.market_id')
        ->leftjoin('user_markets','user_markets.market_id','=','markets.id')
        ->select('earnings.id','earnings.market_id','earnings.total_orders','earnings.admin_earning',
        'earnings.market_earning','earnings.delivery_fee','earnings.tax','earnings.updated_at',
        'markets.name as market_name')
        ->where('user_markets.user_id', '=', $manager_id)
        ->get();

        return $this->sendResponse($earnings->toArray(), 'Earnings retrieved successfully');
   
    }
}
