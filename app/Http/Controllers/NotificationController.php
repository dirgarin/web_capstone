<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\VAPID;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function saveSub(Request $request)
    {
        if(Notification::where('endpoint', $request->input('endpoint'))->count() > 0) {
            return response()->json(['message' => 'Already exists'], 200);
        }else{
            $notification = new Notification();
            $notification->user_id = auth()->user()->id;
            $notification->endpoint = $request->endpoint;
            $notification->public_key = $request->p256dh;
            $notification->auth_token = $request->auth;
            $notification->save();

            return response()->json(['message' => 'success'], 200);
        }
    }

    public function saveNotif($user_id, $endpoint, $public_key, $auth_token)
    {

            $notification = new Notification();
            $notification->user_id = $user_id;
            $notification->endpoint = $endpoint;
            $notification->public_key = $public_key;
            $notification->auth_token = $auth_token;
            $notification->save();

            return response()->json(['message' => 'success'], 200);
    }


    public function sendNotification($user_id, $title, $body, $url)
    {
        $auth = [
            'VAPID' => [
                'subject' => 'Capstone',
                'publicKey' => env('VAPID_PUBLIC_KEY'),
                'privateKey' => env('VAPID_PRIVATE_KEY'),
            ],
        ];

        $webPush = new WebPush($auth);

        $payload = json_encode([
            'title' => $title,
            'body' => $body,
            'url' => $url
        ]);

        $notifications = Notification::where('user_id', $user_id)->get();


        foreach ($notifications as $notification) {
            $webPush->sendOneNotification(
                Subscription::create([
                    'endpoint' => $notification->endpoint,
                    'publicKey' => $notification->public_key,
                    'authToken' => $notification->auth_token,
                    'contentEncoding' => 'aesgcm',
                ]),
                $payload,
                ['TTL' => 5000]
            );
        }

        return response()->json(['message' => 'send successfully'], 200);

    }

    public function sendTimNotification($title, $body, $url)
    {
        $adminUserId = User::where('role', 'tim')->first();
        $auth = [
            'VAPID' => [
                'subject' => 'Capstone',
                'publicKey' => env('VAPID_PUBLIC_KEY'),
                'privateKey' => env('VAPID_PRIVATE_KEY'),
            ],
        ];

        $webPush = new WebPush($auth);

        $payload = json_encode([
            'title' => $title,
            'body' => $body,
            'url' => $url
        ]);

        $notifications = Notification::where('user_id', $adminUserId->id)->get();

        foreach ($notifications as $notification) {
            $webPush->sendOneNotification(
                Subscription::create([
                    'endpoint' => $notification->endpoint,
                    'publicKey' => $notification->public_key,
                    'authToken' => $notification->auth_token,
                    'contentEncoding' => 'aesgcm',
                ]),
                $payload,
                ['TTL' => 5000]
            );
        }

        return response()->json(['message' => 'send successfully'], 200);

    }

    public function test()
    {
        $adminUserId = User::where('role', 'tim')->first();
        $auth = [
            'VAPID' => [
                'subject' => 'Capstone',
                'publicKey' => env('VAPID_PUBLIC_KEY'),
                'privateKey' => env('VAPID_PRIVATE_KEY'),
            ],
        ];

        $webPush = new WebPush($auth);

        $payload = json_encode([
            'title' => 'Test',
            'body' => 'Test',
            'url' => 'https://google.com'
        ]);

        $notifications = Notification::where('user_id', $adminUserId->id)->get();
    
        foreach ($notifications as $notification) {
            $webPush->sendOneNotification(
                Subscription::create([
                    'endpoint' => $notification->endpoint,
                    'publicKey' => $notification->public_key,
                    'authToken' => $notification->auth_token,
                    'contentEncoding' => 'aesgcm',
                ]),
                $payload,
                ['TTL' => 5000]
            );
        }
    
        return response()->json(['message' => 'send successfully'], 200);
    }

    public function readAll(Request $request)
    {
        $user = Auth::user();

        $notifications = \App\Models\ListNotif::where('user_id', $user->id)->get();

        foreach ($notifications as $notification) {
            $notification->status = 'read';
            $notification->save();
        }

        return response()->json(['message' => 'All notifications marked as read']);
    }

}
