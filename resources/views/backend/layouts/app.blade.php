<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <meta name="csrf_token" content="{{csrf_token()}}">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">
    <title>@yield('title')</title>

    <link href="{{asset('backend/css/main.css')}}" rel="stylesheet"></head>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">

    {{-- select 2 js --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{asset('backend/css/style.css')}}">

    @yield('custom-css')
<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
       @include('backend.layouts.header')


        <div class="app-main">
                @include('backend.layouts.sidebar')
                <div class="app-main__outer">
                    <div class="app-main__inner">
                        <div class="container-fluid">
                            @yield('content')
                        </div>



                    </div>

                    <div class="app-wrapper-footer">
                        <div class="app-footer">
                            <div class="app-footer__inner">
                                <div class="app-footer-left">
                                    Copyright {{date('Y')}}. All reserved by Magic Pay
                                </div>
                                <div class="app-footer-right">
                                    Developed By Joseph Jo
                                </div>
                            </div>
                        </div>
                    </div>    </div>

        </div>
    </div>

{{-- datatable --}}
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="{{asset('backend/scripts/main.js')}}"></script></body>

{{-- js validation --}}
<script type="text/javascript" src="{{ url('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

{{-- sweet alert --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- select 2 js --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

{{-- select 2 bootstrap --}}
<link rel="stylesheet" href="/path/to/select2.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

<script>
     $(document).ready(function() {
        $(document).ready(function() {
        let token =document.head.querySelector('meta[name="csrf_token"]');
        if(token){
            $.ajaxSetup({
                headers :{
                    'X-CSRF-TOKEN' : token.content
                }
            })
        }

        $('#back-btn').on('click',function(){
            window.history.go(-1);
            return false;
        })
        });

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    @if(session('create'))
                    Toast.fire({
                    icon: 'success',
                    title: "{{session('create')}}"
                    })
                    @endif

                    @if(session('update'))
                    Toast.fire({
                    icon: 'success',
                    title: "{{session('update')}}"
                    })
                    @endif
     });


</script>

@yield('custom-script')



</html>
