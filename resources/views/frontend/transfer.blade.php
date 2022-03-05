@extends('frontend.layouts.app')

@section('title','Transfer')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="mb-3">
                        <h5 for="" class="mb-1 text-bold">From</h5>
                        <p class="text-muted mb-0">{{$user->name}}</p>
                        <p class="text-muted">{{$user->phone}}</p>
                    </div>
                    <form action="{{route('transfer.confirm')}}" method="GET" id="transfer_Form">
                        <input type="hidden" name="hash_value" value="" id="hashed">

                        <h5 for="" class="mb-1 text-bold">To <span class="checked_phone"></span></h5>
                        <div class="input-group">
                            <input type="text" class="form-control @error('to_phone') is-invalid @enderror" id="to_phone" name="to_phone" value="{{old('to_phone')}}" >
                            <div class="input-group-append">
                              <span class="input-group-text btn" id="check_phone"><i class="fas fa-check-circle"></i></span>
                            </div>
                        </div>
                        @error('to_phone')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror

                        <div class="my-3">
                            <h5 for="" class="mb-1 text-bold">Amount</h5>
                            <input type="text" class="form-control  @error('amount') is-invalid @enderror" id="amount" placeholder="0.00" name="amount" value="{{old('amount')}}">
                            @error('amount')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>

                        <div class="mb-3">
                            <h5 for="" class="mb-1 text-bold">Description</h5>
                            <textarea  class="form-control" id="desc" cols="10" rows="3" name="description" ></textarea>
                        </div>

                        <button class="btn btn-primary btn-block my-5 btn-theme" id="submit_btn">Continue</button>
                    </form>



                </div>
            </div>
        </div>


    </div>
@endsection

@section('custom_script')
    <script>
        $( document ).ready(function() {
            //check phone
            $( "#check_phone" ).on( "click", function() {

                let phone = $( "#to_phone" ).val();
                $.ajax({
                    url: `/check_to_phone?phone=${phone}`,
                    type : 'GET',
                    success: function(res){
                        if(res.status =='success'){
                            $( ".checked_phone" ).removeClass( "text-danger")
                            // $( ".checked_phone" ).removeClass( "text-success")
                            $(".checked_phone").addClass("text-success");
                        }else{
                            $( ".checked_phone" ).removeClass( "text-danger")
                            // $( ".checked_phone" ).removeClass( "text-success")
                            $(".checked_phone").addClass("text-danger");
                        }
                        $(".checked_phone").text(`(${res.data})`);
                    },
                });
            });


            $( "#submit_btn" ).on( "click", function(e) {
                e.preventDefault();
                let to_phone =$('#to_phone').val();
                let amount =$('#amount').val();
                let desc =$('textarea#desc').val()

                $.ajax({
                    type: 'GET',
                    url: `/transfer_hash?to_phone=${to_phone}&amount=${amount}&description=${desc}`,
                    success:function(res){
                        if(res.status){
                            $('#hashed').val(res.data);
                            $('#transfer_Form').submit();
                        }

                    }
                    });
            });

        });
    </script>
@endsection
