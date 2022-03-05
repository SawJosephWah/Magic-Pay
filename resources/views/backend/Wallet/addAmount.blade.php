@extends('backend.layouts.app')

@section('title','Wallet Add Amount')

@section('wallet-active','mm-active')

@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-users icon-gradient bg-mean-fruit">
                </i>
            </div>
            <div>Wallet Add Amount
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

            <form action="{{route('admin.wallet.addAmount.store')}}" method="POST">
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

//    let datatable =  $('#admins').DataTable( {
//         "responsive": true,
//         "processing": true,
//         "serverSide": true,
//         "ajax": "/admin/wallet/ssd",
//         columns :[
//         {
//             data : 'account_number',
//             name : 'account_number'
//         },
//         {
//             data : 'user_id',
//             name : 'user_id'
//         },
//         {
//             data : 'amount',
//             name : 'amount'
//         },
//         {
//             data : 'created_at',
//             name : 'created_at'
//         },
//         {
//             data : 'updated_at',
//             name : 'updated_at'
//         },
//         ],
//         order: [
//             [ 3, "desc" ]
//             ]
// } );

$(document).ready(function() {
    $('.user_id').select2();
});
</script>

@endsection
