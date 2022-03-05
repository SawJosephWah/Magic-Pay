@extends('backend.layouts.app')

@section('title','Wallet Reduce Amount')

@section('wallet-active','mm-active')

@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-users icon-gradient bg-mean-fruit">
                </i>
            </div>
            <div>Wallet Reduce Amount
            </div>
        </div>

    </div>
</div>


<div class="content my-3">
    <div class="card">
        <div class="card-body">
            @error('general')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <form action="{{route('admin.wallet.reduceAmount.reduce')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label>User</label>
                    <select name="user_id" id="" class="form-control user_id @error('user_id') border-danger @enderror">
                        <option value="">--</option>
                        @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->name}} ({{$user->phone}})</option>
                        @endforeach
                    </select>
                    @error('user_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Amount</label>
                    <input type="number" name="amount" value="{{old('amount')}}" class="form-control @error('amount') border-danger @enderror">
                    @error('amount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" id="" cols="30" rows="4" class="form-control"></textarea>
                </div>

                <div class="d-flex justify-content-center">
                    <button class="btn btn-primary" type="submit">CONFIRM</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection



@section('custom-script')
<script>


$(document).ready(function() {
    $('.user_id').select2();
});
</script>

@endsection
