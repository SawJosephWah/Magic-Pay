<?php

namespace App\Http\Controllers\Backend;

use App\Admin;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreAdminUser;
use App\Http\Requests\UpdateAdminUser;
use Carbon\Carbon;

class AdminUserController extends Controller
{

    public function index()
    {
        return view('Backend.AdminUser.index');
    }

    //ssd
    public function ssd(){
        $data = Admin::query();

        return Datatables::of($data)
        ->editColumn('user_agent',function($each){
            $agent = new Agent();
            $agent->setUserAgent($each->user_agent);
            $device = $agent->device();
            $platform = $agent->platform();
            $browser = $agent->browser();

            if($each->user_agent){
                return '<table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Device</th>
                        <td>'. $device.'</td>
                    </tr>
                    <tr>
                        <th>Plarform</th>
                        <td>'. $platform .'</td>
                    </tr>

                    <tr>
                        <th>Browser</th>
                        <td>'.$browser.'</td>
                    </tr>
                </tbody>
                </table>';
            }

            return '-';

        })
        ->editColumn('created_at',function($each){
            return Carbon::parse($each->created_at)->format('Y-m-d H:i:s');
        })
        ->editColumn('updated_at',function($each){
            return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
        })
        ->addColumn('action' , function($each){
            $edit_icon ='<a href="'.route('admin.admin-user.edit',$each->id).'" class="text-warning"><i class="fas fa-edit"></i></a>';
            $delete_icon = ' <a href="" class="text-danger" id="delete-btn" data-id="'.$each->id.'"><i class="fas fa-trash"></i></a>';
            return '<div class="admin-edit-delete">'.$edit_icon. $delete_icon.'</div>';
        })
        ->rawColumns([
            'user_agent','action'
        ])
        ->make(true);
    }


    public function create()
    {
        return view('backend.AdminUser.create');
    }


    public function store(StoreAdminUser $request)
    {

        $user = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone
        ];

        Admin::create($user);

        return redirect('/admin/admin-user')->with('create','Admin User Successfully Created');
    }


    public function show($id)
    {
        dd('here');

    }

    public function edit($id)
    {   $admin_user = Admin::findOrFail($id);
        return view('backend.AdminUser.edit')->with('admin_user',$admin_user);
    }


    public function update(UpdateAdminUser $request, $id)
    {


        $admin_user = Admin::findOrFail($id);
        $new_data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $admin_user->password,
            'phone' => $request->phone
        ];

        $admin_user->update($new_data);

        return redirect('/admin/admin-user')->with('update','Successfully Updated');
    }


    public function destroy($id)
    {
        Admin::findOrFail($id)->delete();
    }


}
