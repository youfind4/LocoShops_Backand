<?php

namespace App\Http\Controllers\API\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

USE DB;
class ManagerAppOrdersStatusesAPIController extends Controller
{
    function index(Request $request)
    {

        $manager_id = $request->id;

        $faq = DB::table('order_statuses')
        ->select('id','status','updated_at')
        ->get();

        return $this->sendResponse($faq->toArray(), 'Faqs retrieved successfully');
   
    }
}
