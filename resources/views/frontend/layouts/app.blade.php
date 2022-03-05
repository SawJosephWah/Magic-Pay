<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf_token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    {{-- bootstrap --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    {{-- font awesome --}}
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    {{-- google font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,400;1,300&display=swap" rel="stylesheet">

    {{-- date range picker --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <link rel="stylesheet" href="{{asset('frontend/style.css')}}">

    {{-- custom css --}}
    @yield('custom_css')

</head>
<body>

    {{-- <div class="container-fluid"> --}}
         {{-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav> --}}

        <div class="header-menu">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-8" >
                    <div class="row">
                        <div class="col-2 text-center">
                            @if (!request()->is('/'))
                            <a href="#" id="back">
                                <i class="fas fa-angle-left"></i>
                            </a>
                            @endif

                        </div>
                        <div class="col-8 text-center">
                            <h3>
                                @yield('title')
                            </h3>
                        </div>
                        <div class="col-2 text-center">
                            <div >
                                <a href="{{route('notifications')}}" style="position: relative">
                                    <i class="fas fa-bell mb-2" >
                                    </i>
                                    @if(!empty($unread_noti_count))
                                    <div class="badge badge-danger app_notifiation_count" style="">{{$unread_noti_count}}</div>
                                    @endif
                                </a>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- content --}}
        <div style="padding-top: 100px; padding-bottom : 120px">
            <div class="container">
                @yield('content')
            </div>
        </div>




        <div class="button-menu">
            <a href="{{route('san_and_pay')}}" class="scan-tab">
                <div class="inside">
                    <i class="fas fa-qrcode"></i>
                </div>
            </a>
            <div class="row justify-content-center">
                <div class="col-md-8" >
                    <div class="row">
                        <div class="col-3 text-center">
                            <a href="{{route('home')}}" >
                                <i class="fas fa-home"></i>
                                <p>Home</p>
                            </a>
                        </div>
                        <div class="col-3 text-center">
                            <a href="{{route('wallet')}}">
                                <i class="fas fa-wallet"></i>
                                <p>Wallet</p>
                            </a>
                        </div>
                        <div class="col-3 text-center">
                            <a href="{{route('transactions_list')}}">
                                <i class="fas fa-exchange-alt"></i>
                                <p>Transaction</p>
                            </a>
                        </div>
                        <div class="col-3 text-center">
                            <a href="{{route('profile')}}">
                                <i class="fas fa-user"></i>
                                <p>Account</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{-- </div> --}}



    {{-- script --}}
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>

    <script src="https://unpkg.com/@popperjs/core@2" ></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    {{-- sweet alert --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- date ranng picker --}}
    <script  src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
   $(document).ready(function() {

        let token =document.head.querySelector('meta[name="csrf_token"]');
        if(token){
            $.ajaxSetup({
                headers :{
                    'X-CSRF-TOKEN' : token.content,
                    'Content-type' : 'Application/json',
                    'Accept' : 'Application/json',
                }
            })
        }

        $( "#back" ).click(function(e) {
            e.preventDefault();
            window.history.back();
            return false;
        });

        //sweet alert
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

                    @if(session('success'))
                    Toast.fire({
                    icon: 'success',
                    title: "{{session('success')}}"
                    })
                    @endif


     });
    </script>
    {{-- custom script --}}
    @yield('custom_script')
</body>
</html>
