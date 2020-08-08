<?php

namespace App\Http\Controllers\API\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Eastwest\Json\Facades\Json;
use DB;

class ManagerAppMarketsAPIController extends Controller
{
    function index(Request $request)
    {
        $manager_id = $request->id;

        $faq = DB::table('markets')
            ->leftjoin('user_markets', 'user_markets.market_id', '=', 'markets.id')
            ->leftjoin('media','media.model_id','=','markets.id')
            ->select(
                'markets.id',
                'markets.name as market_name',
                'markets.description',
                'markets.address',
                'markets.phone',
                'markets.mobile',
                'markets.available_for_delivery',
                'markets.closed',
                'markets.updated_at',
                'markets.delivery_fee',
                'markets.delivery_range',
                'markets.default_tax',
                'markets.latitude',
                'markets.longitude',
                'markets.information',
                'media.id as media_id',
                'media.file_name'
            )
            ->where('user_markets.user_id', '=', $manager_id)
            ->where('media.model_type','=','App\Models\Market')
            ->get();

        return $this->sendResponse($faq->toArray(), 'Faqs retrieved successfully');
    }
    
    function create_market(Request $request){
        
        $user_id = $request->user_id;
        $name = $request->market_name;
        $description = $request->description;
        $address = $request->address;
        $phone = $request->phone;
        $mobile = $request->mobile;
        $available_for_delivery = $request->available_for_delivery;
        $closed = $request->closed;
        $delivery_fee = $request->delivery_fee;
        $delivery_range = $request->delivery_range;
        $default_tax = $request->default_tax;
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $information = $request->information;
        $image = $request->file('image');

        $update = DB::table('markets')
			->insert([
                'name' => $name, 'description' => $description,
                'address' => $address, 'latitude' => $latitude,
                'phone' => $phone, 'mobile' => $mobile, 'longitude' => $longitude,
                'information' => $information, 'delivery_fee' => $delivery_fee,
                'delivery_range' => $delivery_range, 'default_tax' => $default_tax,
                'closed' => $closed, 'available_for_delivery' => $available_for_delivery,
                'delivery_range' => $delivery_range
            ]);
            $market_id =  DB::getPdo()->lastInsertId();
            $drivers = $request->drivers;

            $insert2 = DB::table('user_markets')
            ->insert(['user_id' => $user_id, 'market_id' => $market_id]);

            $driver_n = json_decode($drivers);
            foreach($driver_n as $var) {
                  $insert5 = DB::table('driver_markets')->insert(['user_id' => $var->id, 'market_id' => $market_id]);
                 }


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
            ->insert(['model_type' => 'App\Models\Market',
                      'model_id' =>  $market_id,
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


    
        return $this->sendResponse($insert5, 'Inserted Succesfully');

    }

    function update(Request $request)
    {
        $id = $request->id;
        $name = $request->market_name;
        $description = $request->description;
        $address = $request->address;
        $phone = $request->phone;
        $mobile = $request->mobile;
        $available_for_delivery = $request->available_for_delivery;
        $closed = $request->closed;
        $delivery_fee = $request->delivery_fee;
        $delivery_range = $request->delivery_range;
        $default_tax = $request->default_tax;
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $information = $request->information;
        $drivers = $request->drivers;
        $image = $request->file('image');
        $media_id = $request->media_id;
        $driver_market = json_decode($drivers);
        
        $update = DB::table('markets')->where('id', $id)
			->update([
                'name' => $name, 'description' => $description,
                'address' => $address, 'latitude' => $latitude,
                'phone' => $phone, 'mobile' => $mobile, 'longitude' => $longitude,
                'information' => $information, 'delivery_fee' => $delivery_fee,
                'delivery_range' => $delivery_range, 'default_tax' => $default_tax,
                'closed' => $closed, 'available_for_delivery' => $available_for_delivery,
                'delivery_range' => $delivery_range
            ]);
        $del = DB::table('driver_markets')->where('market_id',$id)
        ->delete();
        
          foreach($driver_market as $driver_id){
            $insert2 = DB::table('driver_markets')
            ->insert(['user_id' => $driver_id->id, 'market_id' => $id]);
          }
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
            
        return $this->sendResponse($update, 'Market Updated Succesfully');
    }
    
   	    function delete(Request $request)
    {

        $market_id = $request->market_id;

        $delete = DB::table('markets')->where('id','=', $market_id)->delete();

        return $this->sendResponse('deleted','Market deleted successfully');;


    }
}
