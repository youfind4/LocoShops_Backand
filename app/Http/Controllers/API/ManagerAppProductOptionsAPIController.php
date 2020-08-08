<?php

namespace App\Http\Controllers\API\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

USE DB;
class ManagerAppProductOptionsAPIController extends Controller
{
    function index(Request $request)
    {

        $manager_id = $request->id;

        $faq = DB::table('options')
        ->leftjoin('products','products.id','=','options.product_id')
        ->leftjoin('user_markets','user_markets.market_id','=','products.market_id')
        ->leftjoin('option_groups','option_groups.id','=','options.option_group_id')
        ->select('options.*','products.name as product_name','option_groups.name as option_group')
          ->where('user_markets.user_id','=',$manager_id)
        ->get();

        return $this->sendResponse($faq->toArray(), 'Faqs retrieved successfully');
   
    }
	  function create_option(Request $request){
		  
      $name = $request->name;
      $description = $request->description;
      $price = $request->price;
      $product_id = $request->product_id;
      $option_group_id = $request->option_group_id;

      $insert = DB::table('options')
          ->insert([
              'name' => $name,
              'description' => $description,
              'price' => $price,
              'product_id' => $product_id,
              'option_group_id' => $option_group_id
          ]);


      return $this->sendResponse($insert, 'Payouts Inserted successfully');

    }
	    function update_option(Request $request){
      $id= $request->id;
      $name = $request->name;
      $description = $request->description;
      $price = $request->price;
      $product_id = $request->product_id;
      $option_group_id = $request->option_group_id;

      $insert = DB::table('options')->where('id','=',$id)
          ->update([
              'name' => $name,
              'description' => $description,
              'price' => $price,
              'product_id' => $product_id,
              'option_group_id' => $option_group_id
          ]);


      return $this->sendResponse($insert, 'Payouts Inserted successfully');

    }
	
	function delete(Request $request)
    {

        $option_id = $request->option_id;

        $delete = DB::table('options')->where('id','=', $option_id)->delete();

        return $this->sendResponse('deleted','data deleted successfully');;


    }
	
	
	
}
