<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\PaytmGenerateToken;
use App\Http\Controllers\Controller;

class PaytmGenerateTokenAPIController extends Controller
{
    private $paymentRepository;
    public function __construct(PaytmGenerateToken $paytm)
    {
        $this->paymentRepository = $paytm;
    }
    public function get_token(Request $request)
    {
        $order_id = $request->order_id;
        $mid = $request->marchent_id;
        $mkey = $request->marchent_key;
  

        $paytmParams = array();

        $paytmParams["body"] = array(
            "requestType"   => "Payment",
            "mid"           => $mid,
            "websiteName"   => "WEBSTAGING",
            "orderId"       => $order_id,
            "txnAmount"     => array(
                "value"     => "1.00",
                "currency"  => "INR",
            ),
            "userInfo"      => array(
                "custId"    => "CUST_001",
            ),
        );

        $checksum = $this->paymentRepository->generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), $mkey);
        $paytmParams["head"] = array(
            "signature"	=> $checksum
        );
        
        $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

        /* for Staging */
        $url = "https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid=".$mid."&orderId=".$order_id;

        /* for Production */
        // $url = "https://securegw.paytm.in/theia/api/v1/initiateTransaction?mid=".$mid."&orderId=".$order_id;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); 
        $response = curl_exec($ch);
        $json   = json_decode($response,TRUE);
        return $json; 
    }
}