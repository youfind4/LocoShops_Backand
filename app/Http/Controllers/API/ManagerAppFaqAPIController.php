<?php

namespace App\Http\Controllers\API\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

USE DB;

class ManagerAppFaqAPIController extends Controller
{
    function index()
    {
        $faq = DB::table('faqs')
        ->join('faq_categories','faq_categories.id','=','faqs.faq_category_id')
        ->select('faqs.id','faqs.question','faqs.answer','faqs.faq_category_id','faqs.updated_at','faq_categories.name as faq_category_name')
        ->get();

        return $this->sendResponse($faq->toArray(), 'Faqs retrieved successfully');
   
    }
}


