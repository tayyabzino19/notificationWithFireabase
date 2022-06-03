<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function allowNotification()
    {
        return view('allow');
    }
    public function dashboard()
    {
        $id=  Auth::user()->id;
        $orders = Order::where('user_id',$id)->get();
        return view('dashboard',compact('orders'));
    }

    public function create(Request $request)
    {
        $order = new Order;
        $order->user_id = Auth()->user()->id;
        $order->total = 1000;
        $order->status = 'order';
        if($order->save()){

            $url = 'https://fcm.googleapis.com/fcm/send';
            $FcmToken = User::whereNotNull('fcm_token')->pluck('fcm_token')->all();
            $serverKey = 'AAAAMJTS_hs:APA91bG2OvAw5DUMtJshyqVLeAlX-tA72JDC-A4eZfFyK87GPUynTnS1FxnnCJHA4AsFWTJmnNUs8wBHbMm1MTc6buZq4R2ErypavRArnvGCMBVXbL-FHidmi7aIkMoh14ESr-3RUykh';
            $data = [
                "registration_ids" => $FcmToken,
                "notification" => [
                    "title" => 'TItle',
                    "body" => 'Body',
                ]
            ];
            $encodedData = json_encode($data);
            $headers = [
                'Authorization:key=' . $serverKey,
                'Content-Type: application/json',
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            // Disabling SSL Certificate support temporarly
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
            // Execute post
            $result = curl_exec($ch);
            if ($result === FALSE) {
                die('Curl failed: ' . curl_error($ch));
            }
            // Close connection
            curl_close($ch);

        }
    }
}
