<?php

namespace App\Http\Controllers\API\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
class ManagerAppDriversAPIController extends Controller
{
    function index()
    {
        $faq = DB::table('drivers')
        ->leftjoin('users','users.id','=','drivers.user_id')
        ->select('drivers.id','drivers.user_id','users.name as drivername')
        ->get();

        return $this->sendResponse($faq->toArray(), 'Drivers retrieved successfully');
   
    }
    
        function market_driver(Request $request){
        
        $id = $request->id;
        $faq = DB::table('driver_markets')->where('market_id',$id)
        ->select('driver_markets.*')
        ->get();

        return $this->sendResponse($faq->toArray(), 'Drivers retrieved successfully');
        
    }
}
?>