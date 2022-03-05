@extends('frontend.layouts.app')

@section('title','Transactions')

@section('content')
    <div class="transaction_list">
        <div class="card mb-2">
            <div class="card-body p-2">
                <div class="row align-items-center">

                    <div class="col-6 col-md-3">
                        <div class="input-group my-2">
                            <div class="input-group-prepend">
                              <label class="input-group-text" for="inputGroupSelect01">Date</label>
                            </div>
                            <input class="form-control" type="text" id="date" value="{{request()->date}}" placeholder="All">
                          </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="input-group my-2">
                            <div class="input-group-prepend">
                              <label class="input-group-text" for="inputGroupSelect01">Type</label>
                            </div>
                            <select class="custom-select" id="type">
                              <option value="">All</option>
                              <option value="1" @if(request()->type == 1) selected @endif>Income</option>
                              <option value="2" @if(request()->type == 2) selected @endif>Expence</option>
                            </select>
                          </div>
                    </div>

                    <div class="col-4 col-md-2">
                        <a href="{{route('transactions_list')}}">
                            <p class=" p-2 m-0 rounded unique_btn my-auto">All Transaction</p>
                        </a>
                    </div>
                    <div class="col-4 col-md-2">
                        <p class=" p-2 m-0 rounded unique_btn my-auto all_expences_btn ">All Expences</p>
                    </div>
                    <div class="col-4 col-md-2">
                        <p class=" p-2 m-0 rounded unique_btn my-auto all_expences_incomes">All Incomes</p>
                    </div>

                </div>
            </div>
        </div>
        @foreach ($transactions as $transaction)
        <a href="{{route('transaction.details',$transaction->transaction_id)}}">
            <div class="card transaction_list mb-2">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between">

                        <h6 class="mb-1"> Trx_ID : {{$transaction->transaction_id}}</h6>
                        <h6 class="mb-1 @if($transaction->type == 1) text-success @else text-danger @endif">{{$transaction->amount}}</h6>
                    </div>
                    <p class="text-muted mb-0">
                        @if($transaction->type == 1) From @else To @endif
                        - @if($transaction->source == null)
                            Admin
                        @else
                            {{$transaction->source->name}}
                            @endif
                        <br>

                        {{$transaction->created_at}}
                    </p>


                </div>
            </div>
        </a>

    @endforeach

    </div>



@endsection

@section('custom_script')
    <script>
        $( document ).ready(function() {
            $('#date').daterangepicker({
                "singleDatePicker": true,
                "autoApply": false,
                "autoUpdateInput" : false,
                "locale": {
                    "format": "YYYY-MM-DD"
            }});

            $('#date').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD'));
                let date = $('#date').val();
                let type = $( "#type option:selected" ).val();

                history.pushState('','',`?date=${date}&type=${type}`);
                location.reload();
            });

            $('#date').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                let date = $('#date').val();
                let type = $( "#type option:selected" ).val();

                history.pushState('','',`?date=${date}&type=${type}`);
                location.reload();
            });


            $( "#type" ).change(function(){
                let date = $('#date').val();
                let type = $( "#type option:selected" ).val();

                history.pushState('','',`?date=${date}&type=${type}`);
                location.reload();
            });

            $( ".all_expences_btn" ).on('click',function(){
                location.replace(`/transactions?type=2`);
            });

            $( ".all_expences_incomes" ).on('click',function(){
                location.replace(`/transactions?type=1`);
            });

        });
    </script>
@endsection
