<?php

namespace App\Http\Controllers\API\Manager;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

USE DB;
class ManagerAppMarketPayoutsAPIController extends Controller
{
    function index(Request $request)
    {
        $manager_id = $request->manager_id;
        $earnings = DB::table('markets_payouts')
        ->leftjoin('markets','markets.id','=','markets_payouts.market_id')
        ->leftjoin('user_markets','user_markets.market_id','=','markets.id')
        ->select('markets_payouts.id','markets_payouts.market_id','markets_payouts.method',
        'markets_payouts.amount','markets_payouts.paid_date','markets_payouts.note','markets.name as market_name')
        ->where('user_markets.user_id', '=', $manager_id)
        ->get();

        return $this->sendResponse($earnings->toArray(), 'Earnings retrieved successfully');
   
    }


    function getPayments(Request $request){

        $manager_id = $request->manager_id;
        $earnings = DB::table('payments')
        ->leftjoin('orders','orders.payment_id','=','payments.id')
        ->leftjoin('product_orders','product_orders.order_id','=','orders.id')
        ->leftjoin('products','products.id','=','product_orders.product_id')
        ->join("user_markets", "user_markets.market_id", "=", "products.market_id")
        ->leftjoin('users','users.id','=','user_markets.user_id')
        ->leftjoin('users as uc','uc.id','=','payments.user_id')
        ->select('payments.*','uc.name as username')
        ->where('user_markets.user_id', '=', $manager_id)
        ->get();

        return $this->sendResponse($earnings->toArray(), 'Earnings retrieved successfully');

    }
        function getdrivers(Request $request){

        $manager_id = $request->manager_id;
        $earnings = DB::table('drivers')
        ->join("driver_markets", "driver_markets.user_id", "=", "drivers.user_id")
		->join("users","users.id","=","drivers.user_id")
        ->join("user_markets", "user_markets.market_id", "=", "driver_markets.market_id")
        ->select('drivers.*','users.name as driver_name')->distinct('drivers.id')
        ->where('user_markets.user_id', '=', $manager_id)
        ->get();

        return $this->sendResponse($earnings->toArray(), 'Earnings retrieved successfully');

    }
    function insert_payout(Request $request){
        
            $market_id = $request->market_id;
            $method = $request->method;
            $amount = $request->amount;
            $note = $request->note;

            $insert = DB::table('markets_payouts')
                ->insert([
                    'market_id' => $market_id,
                    'method' => $method,
                    'amount' => $amount,
                    'note' => $note,
                ]);
    
    
            return $this->sendResponse($insert, 'Payouts Inserted successfully');
    }
}
