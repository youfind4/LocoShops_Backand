<?php

namespace App\Http\Controllers\API\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
class ManagerAppUserProfileAPIController extends Controller
{
    function index(Request $request)
    {

        $manager_id = $request->manager_id;

        $faq = DB::table('users')
            ->leftjoin('custom_field_values','custom_field_values.customizable_id','=','users.id')
            ->leftjoin('custom_fields','custom_fields.id','=','custom_field_values.custom_field_id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'custom_fields.id as custom_field_id',
                'custom_fields.name as custom_field_name',
                'custom_field_values.id as custom_field_values_id',
                'custom_field_values.value as custome_field_value',
                'custom_field_values.view as custome_field_view'
             )
            ->where('users.id', '=', $manager_id)
            ->get();

        return $this->sendResponse($faq->toArray(), 'Faqs retrieved successfully');
    }
    
    
	  function update(Request $request)
    {
		$manager_id = $request->manager_id;
        $name = $request->name;
        $email = $request->email;
        $phone_id = $request->phone_id;
        $bio_id = $request->bio_id;
        $address_id = $request->address_id;
        $phone = $request->phone;
        $bio = $request->bio;
        $address = $request->address;
 
        $insert = DB::table('users')->where('id','=', $manager_id)
            ->update([
                'name' => $name,
                'email' => $email
            ]);
            
         $insert1 = DB::table('custom_field_values')->where('id','=', $phone_id)
            ->update([
                'value' => $phone,
                'view' => $phone
            ]);
            
            $insert2 = DB::table('custom_field_values')->where('id','=', $bio_id)
            ->update([
                'value' => $bio,
                'view' => $bio
            ]);
            $insert3 = DB::table('custom_field_values')->where('id','=', $address_id)
            ->update([
                'value' => $address,
                'view' => $address
            ]);
         

        return $this->sendResponse($insert, 'Product Inserted successfully');
    }

}
