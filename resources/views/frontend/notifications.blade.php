@extends('frontend.layouts.app')

@section('title','Notifications')

@section('content')
    <div class="notification_list">
        @foreach ($notifications as $notification)
        <a href="{{route('notificationDetails',$notification->id)}}">
            <div class="card notification_list mb-2">
                <div class="card-body p-3">
                    <h6 class="mb-1"><i class="fas fa-bell mr-2 @if(!isset($notification->read_at)) text-danger @endif"></i>{{Illuminate\Support\Str::limit( $notification->data['title'], 20)}}</h6>
                    <p class="m-0">{{Illuminate\Support\Str::limit($notification->data['message'], 50)}}</p>
                    <div class="d-flex justify-content-end">
                        <small class="m-0 text-muted">{{date('Y-m-d h:i A', strtotime($notification->created_at))}}</small>
                    </div>
                </div>
            </div>
        </a>

    @endforeach

    </div>



@endsection


