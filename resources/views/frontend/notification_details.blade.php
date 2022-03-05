
@extends('frontend.layouts.app')

@section('title','Notification')

@section('content')

        <div class="card noti-details">
            <div class="card-body"><div class="text-center">
                <img src="{{asset('img/scan_and_pay.png')}}" alt="" width="200">
            </div>
            <div class="text-center">
                <h6>{{$notification->data['title']}}</h6>
                <h6 class="mb-3">{{$notification->data['message']}}</h6>
                <a href="{{$notification->data['web_link']}}" class="btn btn-theme btn-sm">Continue</a>
            </div>
        </div>

        </div>



@endsection

