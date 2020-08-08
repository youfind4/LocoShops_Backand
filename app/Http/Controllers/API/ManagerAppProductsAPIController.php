<?php

namespace App\Http\Controllers\API\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

USE DB;
class ManagerAppProductsAPIController extends Controller
{
    function index(Request $request)
    {
        $manager_id = $request->id;

        $faq = DB::table('products')->distinct('media.model_id')
        ->leftjoin('user_markets','user_markets.market_id','=','products.market_id')
        ->leftjoin('categories','categories.id','=','products.category_id')
        ->leftjoin('markets','markets.id','=','products.market_id')
        ->leftjoin('media','media.model_id','=','products.id')
        ->select('products.*','categories.name as category_name',
		'markets.name as market_name','media.id as media_id','media.file_name')
         ->where('user_markets.user_id','=',$manager_id)
         ->where('media.model_type','=','App\Models\Product')
         ->get();

        return $this->sendResponse($faq->toArray(), 'Faqs retrieved successfully');
   
    }
	
    function insertproduct(Request $request)
    {
        $name = $request->product_name;
        $price = $request->price;
        $discount_price = $request->discount_price;
        $description = $request->description;
        $capacity = $request->capacity;
        $package_items_count = $request->package_items_count;
        $unit = $request->unit;
        $featured = $request->featured;
        $deliverable = $request->deliverable;
        $market_id = $request->market_id;
        $category_id = $request->category_id;
        $image = $request->file('image');
        $image_name = $request->image_name;
        $media_id = $request->media_id;
        
        $insert = DB::table('products')
            ->insert([
                'name' => $name,
                'price' => $price,
                'discount_price' => $discount_price,
                'description' => $description,
                'capacity' => $capacity,
                'package_items_count' => $package_items_count,
                'unit' => $unit,
                'featured'=>$featured,
                'deliverable'=>$deliverable,
                'market_id'=>$market_id,
                'category_id'=>$category_id,
            ]);
            
            $product_id =  DB::getPdo()->lastInsertId();
            
            $uu = rand(1000,100000);
            $inserts1 = DB::table('uploads')
            ->insert(['uuid' => 'basbdbsab-'. $uu.'-basbdbsab']);
            
            $uuid_id = DB::getPdo()->lastInsertId();
            
            $ext = $image->getClientOriginalExtension();
            $nname = time();
            
            $photoName = $nname . '.' . $ext;
            
            $size1 = $image->getSize();
            $photonameic = $nname .'-icon.'. $ext;
            $photomaneth = $nname .'-thumb.'. $ext;
            
            $insert2 = DB::table('media')
            ->insert(['model_type' => 'App\Models\Upload',
                      'model_id' => $uuid_id,
                      'collection_name' =>'avatar',
                      'name' => $nname,
                      'file_name' => $photoName,
                      'mime_type' => 'image/'.$ext,
                      'disk' => 'public',
                      'size' => $size1,
                      'manipulations' =>'[]',
                      'custom_properties' => ' {"uuid":"basbdbsab-'.$uu.'-basbdbsab","user_id":33,"generated_conversions":{"thumb":true,"icon":true}}',
                      'responsive_images' => '[]',
                      'order_column' => '495'
                      ]);
                      
            $upload_m = DB::getPdo()->lastInsertId();     
           
            $insert3 = DB::table('media')
            ->insert(['model_type' => 'App\Models\Product',
                      'model_id' => $product_id,
                      'collection_name' =>'image',
                      'name' =>$nname,
                      'file_name' => $photoName,
                      'mime_type' => 'image/'.$ext,
                      'disk' => 'public',
                      'size' => $size1,
                      'manipulations' =>'[]',
                      'custom_properties' => ' {"uuid":"basbdbsab-'.$uu.'-basbdbsab","user_id":33,"generated_conversions":{"thumb":true,"icon":true}}',
                      'responsive_images' => '[]',
                      'order_column' => '496'
                      
            ]);
            $product_m = DB::getPdo()->lastInsertId();
            
            $image->storeas(storage_path('..\..\..\..\public/'.$upload_m.'/'), $photoName);
            
            $image->storeas(storage_path('..\..\..\..\public/'.$product_m.'/'), $photoName);
            
            $image->storeas(storage_path('..\..\..\..\public/'.$upload_m.'/conversions/'), $photonameic);
            
            $image->storeas(storage_path('..\..\..\..\public/'.$upload_m.'/conversions/'), $photomaneth);
          
            $image->storeas(storage_path('..\..\..\..\public/'.$product_m.'/conversions/'), $photonameic);
            
            $image->storeas(storage_path('..\..\..\..\public/'.$product_m.'/conversions/'), $photomaneth);


        return $this->sendResponse($insert, 'Product Inserted successfully');
    }
    

	
	  function update_product(Request $request)
    {
		$id = $request->id;
        $name = $request->product_name;
        $price = $request->price;
        $discount_price = $request->discount_price;
        $description = $request->description;
        $capacity = $request->capacity;
        $package_items_count = $request->package_items_count;
        $unit = $request->unit;
        $featured = $request->featured;
        $deliverable = $request->deliverable;
        $market_id = $request->market_id;
        $category_id = $request->category_id;
        $image = $request->file('image');
        $image_name = $request->image_name;
        $media_id = $request->media_id;
        
        $insert = DB::table('products')->where('id','=', $id)
            ->update([
                'name' => $name,
                'price' => $price,
                'discount_price' => $discount_price,
                'description' => $description,
                'capacity' => $capacity,
                'package_items_count' => $package_items_count,
                'unit' => $unit,
                'featured'=>$featured,
                'deliverable'=>$deliverable,
                'market_id'=>$market_id,
                'category_id'=>$category_id,
            ]);
            if($image){
            $ext = $image->getClientOriginalExtension();
            $nname = time();
            
            $photoName = $nname . '.' . $ext;
            
            $size1 = $image->getSize();
            $photonameic = $nname .'-icon.'. $ext;
            $photomaneth = $nname .'-thumb.'. $ext;
            
            // $upload_ids = $media_id - 1;
            // $insert2 = DB::table('media')->where('id','=',$upload_ids)
            // ->update(['name' => $nname,
            //           'file_name' => $photoName,
            //           'mime_type' => 'image/'.$ext,
            //           ]);
           
            $insert3 = DB::table('media')->where('id','=',$media_id)
            ->update(['name' =>$nname,
                      'file_name' => $photoName,
                      'mime_type' => 'image/'.$ext,
            ]);
           
          
            $image->storeas(storage_path('..\..\..\..\public/'.$media_id.'/'), $photoName);
            
            $image->storeas(storage_path('..\..\..\..\public/'.$media_id.'/conversions/'), $photonameic);
            
            $image->storeas(storage_path('..\..\..\..\public/'.$media_id.'/conversions/'), $photomaneth);

        }

        return $this->sendResponse($insert, 'Product Inserted successfully');
    }
	    function option_groups(Request $request)
    {

        $name = $request->option_group;
      
        $insert = DB::table('option_groups')
            ->insert([
                'name' => $name,
            ]);


        return $this->sendResponse($insert, 'Option Group Inserted successfully');
    }
	    function list_catageries(){
        $category = DB::table('categories')
        ->select('id','name')
        ->get();

        return $this->sendResponse($category->toArray(), 'Categories retrieved successfully');
			
    }
	
	    function delete(Request $request)
    {

        $product_id = $request->product_id;

        $delete = DB::table('products')->where('id','=', $product_id)->delete();

        return $this->sendResponse('deleted','data deleted successfully');;


    }

}
