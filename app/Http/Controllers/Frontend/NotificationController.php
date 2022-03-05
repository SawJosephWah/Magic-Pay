<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(){
        $user = Auth::user();

        $notifications = $user->notifications;
        return view('frontend.notifications',compact('notifications'));
    }

    public function show($id){
        $user = Auth::user();
        $notification = $user->notifications->where('id',$id)->first();
        if($notification){
            $notification->markAsRead();
            return view('frontend.notification_details',compact('notification'));
        }

        return redirect()->route('notifications');
    }
}
