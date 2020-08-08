<?php

namespace App\Http\Controllers\API\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

USE DB;
class ManagerAppOrdersAPIController extends Controller
{
    function index(Request $request)
    {

        $manager_id = $request->manager_id;

        $faq = DB::table('orders')
        ->leftjoin("product_orders", "orders.id", "=", "product_orders.order_id")
        ->leftjoin("users","users.id","=","orders.user_id")
        ->leftjoin("users as d","d.id","=","orders.driver_id")
        ->leftjoin("delivery_addresses","delivery_addresses.id","=","orders.delivery_address_id")
        ->leftjoin("payments","payments.id","=","orders.payment_id")
        ->leftjoin("order_statuses","order_statuses.id","=","orders.order_status_id")
        ->leftjoin("products", "products.id", "=", "product_orders.product_id")
			->join("markets","markets.id","=","products.market_id")
        ->leftjoin("user_markets", "user_markets.market_id", "=", "products.market_id")
        ->select('orders.*','users.name as username','order_statuses.status as order_status',
        'd.name as driver_name','delivery_addresses.address as delivery_address',
        'payments.method as payment_method','payments.status as payment_status','markets.name as market_name','markets.address as market_address','product_orders.price','product_orders.quantity','products.name as product_name')
        ->where('user_markets.user_id','=',$manager_id)
        ->groupBy('orders.id')
        ->get();
                   
        return $this->sendResponse($faq->toArray(), 'Faqs retrieved successfully');
   
    }
    function delete(Request $request){
        $fav_id = $request->id;

        $delete = DB::table('orders')->where('id','=', $fav_id)->delete();

        return $this->sendResponse('deleted', 'data deleted successfully');

    }
	
    function total_orders_completed(Request $request)
    {

        $manager_id = $request->manager_id;

        $faq = DB::table('orders')
        ->join("product_orders", "orders.id", "=", "product_orders.order_id")
        ->join("users","users.id","=","orders.user_id")
        ->join("products", "products.id", "=", "product_orders.product_id")
        ->join("user_markets", "user_markets.market_id", "=", "products.market_id")
        ->where('user_markets.user_id','=',$manager_id)
        ->where('orders.order_status_id', '=', "5")->count();
                   
        return $this->sendResponse($faq, 'Faqs retrieved successfully');

    }

    function total_orders_pending(Request $request)
    {

        $manager_id = $request->manager_id;

        $faq = DB::table('orders')
        ->join("product_orders", "orders.id", "=", "product_orders.order_id")
        ->join("users","users.id","=","orders.user_id")
        ->join("products", "products.id", "=", "product_orders.product_id")
        ->join("user_markets", "user_markets.market_id", "=", "products.market_id")
        ->where('user_markets.user_id','=',$manager_id)
        ->where('orders.order_status_id', '=', "1")->count();
                   
        return $this->sendResponse($faq, 'Faqs retrieved successfully');

    }

    function total_orders_recieved(Request $request)
    {

        $manager_id = $request->manager_id;


        $faq = DB::table('orders')
        ->join("product_orders", "orders.id", "=", "product_orders.order_id")
        ->join("users","users.id","=","orders.user_id")
        ->join("products", "products.id", "=", "product_orders.product_id")
        ->join("user_markets", "user_markets.market_id", "=", "products.market_id")
        ->where('user_markets.user_id','=',$manager_id)->count();
                   
        return $this->sendResponse($faq, 'Faqs retrieved successfully');

    }
	    function order_update(Request $request){
        $id= $request->id;
        $order_status_id = $request->order_status_id;
        $driver_id = $request->driver_id;
       
        $insert = DB::table('orders')->where('id',$id)
            ->update(['order_status_id' => $order_status_id,'driver_id' => $driver_id]);
  
  
        return $this->sendResponse('updated', 'Payouts Inserted successfully');

    }
	

}
