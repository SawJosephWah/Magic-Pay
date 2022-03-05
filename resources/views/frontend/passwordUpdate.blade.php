@extends('frontend.layouts.app')

@section('title','Password Change')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 ">
            <div class="update-password">


                <div class="card mb-3 mt-5 mt-md-0">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="{{asset('img/password_update.png')}}" alt="">
                        </div>
                        <form action="{{route('updatePassword')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="">Old Password</label>
                                <input type="password" autofocus class="form-control @error('new_password') is-invalid @enderror" name="old_password">
                                @error('old_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-5">
                                <label for="">New Password</label>
                                <input type="password" class="form-control  @error('new_password') is-invalid @enderror" name="new_password">
                                @error('new_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        <button class="btn btn-theme btn-block" type="submit">Change Password</button>
                    </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_script')
<script>


$(document).ready(function() {



    });
</script>

@endsection
