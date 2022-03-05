@extends('backend.layouts.app')

@section('title','User Wallet')

@section('wallet-active','mm-active')

@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-users icon-gradient bg-mean-fruit">
                </i>
            </div>
            <div>Wallet
            </div>
        </div>

    </div>
</div>

<a href="{{route('admin.wallet.addAmount')}}" class="btn btn-primary">
    <i class="fas fa-plus-circle"></i>
    Add Amount
</a>

<a href="{{route('admin.wallet.reduceAmount')}}" class="btn btn-danger">
    <i class="fas fa-minus-circle"></i>
    Reduce Amount
</a>

<div class="content my-3">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="admins">
                    <thead>
                        <tr>
                            <th>Account Number</th>
                            <th>Account Person</th>
                            <th>Amount (MMK)</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection



@section('custom-script')
<script>

   let datatable =  $('#admins').DataTable( {
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": "/admin/wallet/ssd",
        columns :[
        {
            data : 'account_number',
            name : 'account_number'
        },
        {
            data : 'user_id',
            name : 'user_id'
        },
        {
            data : 'amount',
            name : 'amount'
        },
        {
            data : 'created_at',
            name : 'created_at'
        },
        {
            data : 'updated_at',
            name : 'updated_at'
        },
        ],
        order: [
            [ 3, "desc" ]
            ]
} );
</script>

@endsection
