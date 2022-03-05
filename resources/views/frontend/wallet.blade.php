@extends('frontend.layouts.app')

@section('title','Wallet')

@section('content')

        <div class="card wallet-card">
            <div class="card-body">
                <div class="mb-4">
                    <h6>Balance</h6>
                    <h3>{{ $user->wallets ? number_format($user->wallets->amount, 2) : '0.00'}} <span style="font-size: 15px">MMK</span></h3>
                </div>
                <div class="mb-5">
                    <h6>Account Number</h6>
                    <h3>{{$user->wallets ? $user->wallets->account_number : '-'}}</h3>
                </div>
                <div>
                    <h3>{{$user->name}}</h3>
                </div>

            </div>
        </div>

@endsection
