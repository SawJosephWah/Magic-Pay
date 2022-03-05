@extends('frontend.layouts.app')

@section('title','Transfer')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('transfer')}}" method="POST" id="form">
                        @csrf
                        <input   value="{{$hashed_value}}" name="hashed_value" type="hidden">
                        <input   value="{{$to_user->phone}}" name="to_phone" type="hidden">
                        <input   value="{{$amount}}" name="amount" type="hidden">
                        <input   value="{{$description}}" name="description" type="hidden">
                    </form>


                    <div class="mb-3">
                        <h5 for="" class="mb-1 text-bold">From</h5>
                        <p class="text-muted mb-0">{{$auth_user->name}}</p>
                        <p class="text-muted">{{$auth_user->phone}}</p>
                    </div>
                    <form action="{{route('transfer.confirm')}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <h5 for="" class="mb-1 text-bold">To</h5>
                            <p class="text-muted mb-0">{{$to_user->name}}</p>
                            <p class="text-muted mb-0">{{$to_user->phone}}</p>
                        </div>

                        <div class="mb-3">
                            <h5 for="" class="mb-1 text-bold">Amount</h5>
                            <p class="text-muted mb-0">{{$amount}}</p>
                        </div>

                        <div class="mb-3">
                            <h5 for="" class="mb-1 text-bold">Description</h5>
                            <p class="text-muted mb-0">{{$description}}</p>
                        </div>

                        <button class="btn btn-primary btn-block my-5 btn-theme" id="confirm" type="submit">Confirm</button>
                    </form>

                </div>
            </div>
        </div>


    </div>
@endsection

@section('custom_script')
    <script>
        $( document ).ready(function() {
            $( "#confirm" ).on( "click", function(e) {
                e.preventDefault();


                Swal.fire({
                title: 'Fill your password',
                icon: 'info',
                html:
                    `<input type="password" class="form-control text-center password" autofocus>`,
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Confirm',
                reverseButtons : true
                }).then((result) => {
                    if (result.isConfirmed) {
                        let password = $('.password').val();

                    $.ajax({
                    url: `/transfer_password_check?password=${password}`,
                    type : 'GET',
                    success: function(res){
                        console.log(res.status);
                        if(res.status == 'success'){
                            $( "#form" ).submit();
                        }else if(res.status == 'fail'){

                            Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Wrong Password! Try Again'
                            })
                        }
                    },
                });
                    }


                    })
            });
        });
    </script>
@endsection
