@extends('frontend.layouts.app')

@section('title','Profile')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-md-8 ">
            <div class="account">
                <div class="profile mb-3">
                    <img src="https://ui-avatars.com/api/?background=5842E3&color=fff&name={{$user->name}}" alt="">
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span>Name</span>
                            <span>{{$user->name}}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span>Phone</span>
                            <span>{{$user->phone}}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span>Email</span>
                            <span>{{$user->email}}</span>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <a href="{{route('updatePasswordPage')}}" class="updatepassword">
                            <div class="d-flex justify-content-between">
                                <span>Change Password</span>
                                <span><i class="fas fa-angle-right"></i></span>
                            </div>
                        </a>

                        <hr>
                        <a href="#" class="d-flex justify-content-between " id="logout">
                            <span>Logout</span>
                            <span><i class="fas fa-angle-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_script')
<script>


$(document).ready(function() {


    $('#logout').on('click',function(e){
        e.preventDefault();

            Swal.fire({
                title: 'Do you want to logout?',
                showCancelButton: true,
                confirmButtonText: `Confirm`,
                reverseButtons:true
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{route('logout')}}`,
                        type : 'POST',
                        success : function(){
                            window.location.replace("{{route('login')}}");
                        }
                    });
                }
                })
        })
    });
</script>

@endsection
