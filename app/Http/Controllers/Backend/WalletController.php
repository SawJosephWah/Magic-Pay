<?php

namespace App\Http\Controllers\Backend;

use App\User;
use Throwable;
use App\Wallet;
use Carbon\Carbon;
use App\Transaction;
use Illuminate\Http\Request;
use App\Helpers\UUIDGenerate;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function index(){
        return view('backend.Wallet.index');
    }


    public function ssd(){
        $users = Wallet::with('user');
        return Datatables::of($users)
        ->editColumn('user_id',function($each){
            $user = $each->user;
            if($user){
                return '<p>Name : '.$user->name.'</p> <p>Email : '.$user->email.'</p> <p>Phone : '.$user->phone.'</p>';
            }
            return ' - ';
        })
        ->editColumn('amount',function($each){
            return number_format($each->amount, 2, '.', ',');
        })
        ->editColumn('created_at',function($each){

            $date = Carbon::parse($each->created_at)->format("Y-m-d H:i:s");
            return $date;
        })
        ->editColumn('updated_at',function($each){

            $date = Carbon::parse($each->updated_at)->format("Y-m-d H:i:s");
            return $date;
        })
        ->rawColumns(['user_id'])
        ->make(true);
    }

    public function addAmount(){
        $users = User::orderBy('name')->get();
        // dd($users->toArray());
        return view('backend.Wallet.addAmount',compact('users'));
    }

    public function storeAmount(Request $request){
        // dd($request->all());
        $request->validate([
            'user_id' => 'required',
            'amount' => 'required',
        ]);

        if($request->amount < 500){
            return back()->withErrors(['amount' => 'Amount must be at least 500 MMK'])->withInput();
        }


        try {
            DB::beginTransaction();
            $user = User::find($request->user_id);
            $user_wallet = $user->wallets;
            $user_wallet->increment('amount', $request->amount);
            $user_wallet->update();

            $refNo = UUIDGenerate::refNumber();
            Transaction::create([
            'ref_id' => $refNo,
            'transaction_id' => UUIDGenerate::transNumber(),
            'user_id' => $user->id,
            'type' => 1,
            'amount' => $request->amount,
            'source_id' => 0,
            'description' => $request->description ? $request->description : ''
        ]
        );


        DB::commit();

        return redirect()->route('admin.wallet.index')->with('create','Added Amount Successfully ! ');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('general',$e);
        }

    }

    public function reduceAmount(){
        $users = User::orderBy('name')->get();
        // dd($users->toArray());
        return view('backend.Wallet.reduceAmount',compact('users'));
    }

    public function reduceAmountReduce(Request $request){
        // dd($request->all());
        $request->validate([
            'user_id' => 'required',
            'amount' => 'required',
        ]);

        if($request->amount < 0)
        {
            return back()->withErrors(['amount' => 'Amount must be at least 1 MMK'])->withInput();
        }

        $user = User::find($request->user_id);
        $user_wallet = $user->wallets;
        if($request->amount > $user_wallet->amount)
        {
            return back()->withErrors(['amount' => 'Amount cannot be greater than the current amount in the account.'])->withInput();
        }


        try {
            DB::beginTransaction();

            $user_wallet->decrement('amount', $request->amount);
            $user_wallet->update();

            $refNo = UUIDGenerate::refNumber();
            Transaction::create([
            'ref_id' => $refNo,
            'transaction_id' => UUIDGenerate::transNumber(),
            'user_id' => $user->id,
            'type' => 2,
            'amount' => $request->amount,
            'source_id' => 0,
            'description' => $request->description ? $request->description : ''
        ]
        );


        DB::commit();

        return redirect()->route('admin.wallet.index')->with('create','Reduced Amount Successfully ! ');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('general',$e);
        }
    }
}
