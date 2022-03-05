@extends('backend.layouts.app')

@section('admin-user-active','mm-active')

@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-users icon-gradient bg-mean-fruit">
                </i>
            </div>
            <div>Edit Admin User
            </div>
        </div>

    </div>
</div>



<div class="content mt-3">
    <div class="card">
        <div class="card-body">

            <form action="{{route('admin.admin-user.update',$admin_user->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" value="{{$admin_user->name}}">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control"  name="email" value="{{$admin_user->email}}">
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="number" class="form-control" name="phone" value="{{$admin_user->phone}}">
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="number" class="form-control" name="password">
                </div>

                <div class="d-flex justify-content-center">
                    <button class="btn btn-secondary mr-3" id="back-btn">Back</button>
                    <button class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection





@section('custom-script')
{!! JsValidator::formRequest('App\Http\Requests\UpdateAdminUser') !!}
<script>
    $(document).ready(function() {
} );
</script>

@endsection

