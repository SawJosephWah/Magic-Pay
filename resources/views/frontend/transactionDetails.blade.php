@extends('frontend.layouts.app')

@section('title','Transaction Details')

@section('content')
    <div class="transaction_details">
        <div class="card mt-3">
            <div class="card-body p-3">
                <div class="text-center mb-3">
                    <img src="{{asset('img/checked.png')}}" alt="">
                </div>
                <p class="text-center @if($transaction_datials->type == 1) text-success @else text-danger @endif">
                    {{number_format($transaction_datials->amount) }} MMK
                </p>

                <div class="d-flex justify-content-between">
                    <p class="mb-0 text-muted">Trx_ID</p>
                    <p class="mb-0">{{$transaction_datials->transaction_id}}</p>
                </div>
                <hr>

                <div class="d-flex justify-content-between">
                    <p class="mb-0 text-muted">Reference_Id</p>
                    <p class="mb-0">{{$transaction_datials->ref_id}}</p>
                </div>
                <hr>

                <div class="d-flex justify-content-between">
                    <p class="mb-0 text-muted">Type</p>
                    @if($transaction_datials->type == 1)
                    <span class="badge badge-success">INCOME</span>
                    @else
                    <span class="badge badge-danger">EXPENCE</span>
                    @endif
                </div>
                <hr>

                <div class="d-flex justify-content-between">
                    <p class="mb-0 text-muted">Amount</p>
                    <p class="mb-0">{{number_format($transaction_datials->amount,2)}} MMK</p>
                </div>
                <hr>

                <div class="d-flex justify-content-between">
                    <p class="mb-0 text-muted">Date and Time</p>
                    <p class="mb-0">{{$transaction_datials->created_at}}</p>
                </div>
                <hr>

                <div class="d-flex justify-content-between">
                    @if($transaction_datials->type == 1)
                    <p class="mb-0 text-muted">From</p>
                    @else
                    <p class="mb-0 text-muted">To</p>
                    @endif
                    <p class="mb-0">{{$transaction_datials->source->name}}</p>
                </div>
                <hr>

                <div class="d-flex justify-content-between">
                    <p class="mb-0 text-muted">Description</p>
                    <p class="mb-0">{{$transaction_datials->description}}</p>
                </div>
                <hr>

            </div>
        </div>
    </div>



@endsection
