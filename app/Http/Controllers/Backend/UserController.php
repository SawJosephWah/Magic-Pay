<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\UUIDGenerate;
use App\User;
use App\Wallet;
use Carbon\Carbon;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUser;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index(){
        return view('Backend.User.index');
    }

    public function ssd(){
        $users = User::query();
        return Datatables::of($users)
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
            $edit_icon ='<a href="'.route('admin.user.edit',$each->id).'" class="text-warning"><i class="fas fa-edit"></i></a>';
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
        return view('backend.User.create');
    }


    public function store(StoreUser $request)
    {

        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone
            ]);

            Wallet::firstOrCreate(
                [
                    'user_id' => $user->id
                ],
                [
                    'account_number' => UUIDGenerate::accountGenerate(),
                    'amount' => 0.00
                ]
            );

            DB::commit();
            return redirect('/admin/user')->with('create','User Successfully Created');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['Something went wrong']);
        }

    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('backend.User.edit')->with('user', $user);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail($id);
            $new_data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
                'phone' => $request->phone
            ];

            $user->update($new_data);

            Wallet::firstOrCreate(
                [
                    'user_id' => $user->id
                ],
                [
                    'account_number' => UUIDGenerate::accountGenerate(),
                    'amount' => 0.00
                ]
            );
            DB::commit();

        return redirect('/admin/user')->with('update','Successfully Updated');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withErrors(['Something went wrong']);
    }


    }


    public function destroy($id)
    {
        User::findOrFail($id)->delete();
    }
}
