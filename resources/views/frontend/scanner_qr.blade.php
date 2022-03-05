@extends('frontend.layouts.app')

@section('title','QR Scanner')

@section('content')

        <div class="card qr-scanner">
            <div class="card-body">
                <p class="m-0 text-center">Scan To Pay Me</p>
                <div class="text-center">
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(300)->generate($user->phone)) !!} ">
                </div>
                <p class="m-0 text-center">{{$user->name}}</p>
                <p class="m-0 text-center text-muted">{{$user->phone}}</p>
            </div>
        </div>

@endsection
