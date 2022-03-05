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
            <div>Admin User
            </div>
        </div>

    </div>
</div>

<a href="{{route('admin.admin-user.create')}}" class="btn btn-primary">
    <i class="fas fa-plus-circle"></i>
    Create Admin User
</a>




<div class="content mt-3">

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="admins">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Ip</th>
                            <th class="no-sort">User Agent</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th class="no-sort">Actions</th>
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
        "ajax": "/admin/admin-user/datatable/ssd",
        columns :[
        {
            data : 'name',
            name : 'name'
        },
        {
            data : 'email',
            name : 'email'
        },
        {
            data : 'phone',
            name : 'phone'
        },
        {
            data : 'ip',
            name : 'ip'
        },
        {
            data : 'user_agent',
            name : 'user_agent'
        },
        {
            data : 'created_at',
            name : 'created_at'
        },
        {
            data : 'updated_at',
            name : 'updated_at'
        },
        {
            data : 'action',
            name : 'action',
            sortable : false,
        }
        ],
        order: [
            [ 6, "desc" ]
            ],
        columnDefs : [{
            targets : 'no-sort',
            sortable : false,
            searchable : false
        }]
    } );

    $(document).on('click','#delete-btn',function(e){
        e.preventDefault();

        let id = $(this).data('id');


        Swal.fire({
            title: 'Do you want to save the changes?',
            showCancelButton: true,
            confirmButtonText: `Confirm`,
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/admin-user/${id}`,
                    type : 'DELETE',
                    success : function(){
                        datatable.ajax.reload();
                    }
                });
            }
            })
} );
</script>

@endsection
