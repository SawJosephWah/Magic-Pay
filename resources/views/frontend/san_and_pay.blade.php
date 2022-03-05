@extends('frontend.layouts.app')

@section('title','Scan And Pay')

@section('content')

        <div class="card qr-scanner">
            <div class="card-body">
                @if(Session('error'))
                    <div class="alert alert-danger text-center">{{Session('error')}}</div>
                @enderror
                <p class="m-0 text-center">Scanner</p>
                <div class="text-center">
                    <img src="{{asset('img/scan_and_pay.png')}}" alt="" width="200">
                </div>
                <div class="text-center">
                    <button class="btn btn-theme" data-toggle="modal" data-target="#scanModal">SCAN</button>
                </div>
            </div>
        </div>


        <!-- Scan Modal -->
    <div class="modal fade" id="scanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Scan And Pay</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <video id="scanner" width="100%"></video>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>
@endsection

@section('custom_script')
 <script src="{{asset('frontend/qr-scanner.umd.min.js')}}"></script>

{{-- <script src="https://cdn.jsdelivr.net/npm/qr-scanner@1.3.0/qr-scanner.umd.min.js "></s> --}}
<script>

    $( document ).ready(function() {

            let scanner = document.getElementById('scanner');
            const qrScanner = new QrScanner(scanner, result => {
                if(result){
                    let to_phone = result;
                    qrScanner.stop();
                    $('#scanModal').modal('hide');
                    location.replace(`scan&and&trnasfer?to_phone=${to_phone}`);
                }
            });

            $('#scanModal').on('shown.bs.modal', function (e) {
            qrScanner.start();
            })

            $('#scanModal').on('hidden.bs.modal', function (e) {
            qrScanner.stop();
            })
    });
</script>
@endsection

