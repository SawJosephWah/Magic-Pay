@extends('frontend.layouts.app')

@section('title','Magic Pay')

@section('content')
    <div class="row">
        <div class="col-12">

                    <div class="profile mb-3">
                        <img src="https://ui-avatars.com/api/?background=5842E3&color=fff&name={{$user->name}}" alt="">
                    </div>
                    <p class="text-center">{{$user->name}}</p>
                    <h5 class="text-center mb-3">{{number_format($user->wallets->amount,2)}} MMK</h5>

        </div>


        <div class="col-6 mb-3">
            <a href="{{route('san_and_pay')}}">
                <div class="card shortcut-card">
                    <div class="card-body p-3">
                        <img src="{{asset('img/qr-code-scan.png')}}" alt="">
                        Scan & pay
                    </div>
                </div>
            </a>

        </div>
        <div class="col-6 mb-3">
            <a href="{{route('scannerqr')}}">
                <div class="card shortcut-card">
                    <div class="card-body p-3">
                        <img src="{{asset('img/qr-code.png')}}" alt="">
                        Receive QR
                    </div>
                </div>
            </a>

        </div>

        <div class="col-12">
            <div class="card mb-3">
                <div class="card-body function-bar">
                    <a href="{{route('transfer')}}" class="updatepassword">
                        <div class="d-flex justify-content-between">
                            <span>
                                <img src="{{asset('img/money-transfer.png')}}" alt="">
                                Transfer</span>
                            <span><i class="fas fa-angle-right"></i></span>
                        </div>
                    </a>

                    <hr>
                    <a href="{{route('wallet')}}" class="d-flex justify-content-between " id="logout">
                        <span>
                            <img src="{{asset('img/wallet.png')}}" alt="">
                            Wallet</span>
                        <span><i class="fas fa-angle-right"></i></span>
                    </a>

                    <hr>
                    <a href="{{route('transactions_list')}}" class="d-flex justify-content-between " >
                        <span>
                            <img src="{{asset('img/transaction.png')}}" alt="">
                            Transaction</span>
                        <span><i class="fas fa-angle-right"></i></span>
                    </a>
                </div>
            </div>
        </div>

    </div>
@endsection
