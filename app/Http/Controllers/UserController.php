<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\NewOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SendPushNotification;

class UserController extends Controller
{
    public function update(){

            $user = User::first();
            if($user->status == 'active'){
                $user->status = 'inactive';
            }else if($user->status == 'inactive'){
                $user->status = 'active';
            }
            // Notification::send(null,new SendPushNotification('title','my Mesage','$fcmTokens'));
            $user->save();
            $user->notify(new NewOrderNotification($user));
            return 1;

    }

    public function read($id)
    {
       $user = User::first();
       $user->unreadNotifications->where('id',$id)->markAsRead();
        return back();
    }

    public function updateToken(Request $request){

        try{
            $request->user()->update(['fcm_token'=>$request->token]);
            return response()->json([
                'success'=>true
            ]);
        }catch(\Exception $e){
            report($e);
            return response()->json([
                'success'=>false
            ],500);
        }
    }

    public function index()
    {
        return view('token');
    }
    public function saveToken(Request $request)
    {
            return 21212;
        auth()->user()->update(['fcm_token'=>$request->token]);
        return response()->json(['token saved successfully.']);
    }

    public function sendNotification(Request $request)
    {

        $firebaseToken = User::whereNotNull('fcm_token')->pluck('fcm_token')->all();

        $SERVER_API_KEY = 'AAAAMJTS_hs:APA91bG2OvAw5DUMtJshyqVLeAlX-tA72JDC-A4eZfFyK87GPUynTnS1FxnnCJHA4AsFWTJmnNUs8wBHbMm1MTc6buZq4R2ErypavRArnvGCMBVXbL-FHidmi7aIkMoh14ESr-3RUykh';

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,
            ]
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        dd($response);
    }
}
