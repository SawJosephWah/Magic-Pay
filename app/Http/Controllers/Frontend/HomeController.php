<?php

namespace App\Http\Controllers\Frontend;

use App\User;
use App\Transaction;

use Illuminate\Http\Request;
use App\Helpers\UUIDGenerate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\updatePassword;
use App\Http\Requests\TransferValidate;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Notification;

class HomeController extends Controller
{
    public function home(){
        $user = Auth::user();
        return view('frontend.home',compact('user'));
    }

    public function profile(){
        $user = Auth::user();
        return view('frontend.profile',compact('user'));
    }

    public function updatePasswordPage(){
        return view('frontend.passwordUpdate');
    }

    public function updatePassword(updatePassword $request){
        $old_password = $request->old_password;
        $new_password = $request->new_password;
        $user =  Auth::user();

        if (Hash::check($old_password  ,$user->password )) {
            User::find($user->id)->update([
                'password' => Hash::make($new_password)
            ]);

            $title = 'Changed Password !';
            $message = "Your account password is successfulyl changed !.";
            $sourceable_id=$user->id;
            $sourceable_type = User::class;
            $web_link = url('/profile');

            Notification::send($user, new GeneralNotification($title, $message ,$sourceable_id  ,$sourceable_type ,$web_link));

            return redirect('/profile')->with('success','Updated Successfully');
        }else{
            return redirect()->back()->withErrors(["old_password"=>"Wrong Old Password!"]);
        }
    }

    public function wallet(){
        $user = Auth::user();
        return view('frontend.wallet')->with('user',$user);
    }

    public function transfer(Request $request){
        $user = Auth::user();
        return view('frontend.transfer',compact('user'));
    }

    public function transferHash(Request $request){

        $to_be_hashed = $request->to_phone . $request->amount . $request->description;

        $hashed_value = hash_hmac("sha256" , $to_be_hashed , 'magipay123#@!') ;
       return response()->json([
           'status' => true,
           'data' => $hashed_value
       ]);

    }

    public function transferConfirm(TransferValidate $request){

        $to_be_hashed = $request->to_phone . $request->amount . $request->description;
        $hashed_value2 = hash_hmac("sha256", $to_be_hashed ,'magipay123#@!') ;
        if($hashed_value2 !== $request->hash_value){
            return redirect('/transfer')->withErrors(['to_phone'=>'Some Issue Exists'])->withInput();
        }


        $user = User::where('phone',$request->to_phone)->first();
        $auth_user = Auth::user();

        // dd($request->amount, ' ' , $user->wallets->amount);
        if($request->amount > $auth_user->wallets->amount){
            return redirect('/transfer')->withErrors(['amount'=>'Dont have enough cash'])->withInput();
        }

        if(!$user){
            return redirect('/transfer')->withErrors(['to_phone'=>'To information not found'])->withInput();
        }


        if($request->to_phone == $auth_user->phone){
            return redirect('/transfer')->withErrors(['to_phone'=>'Cannot transfer to your own accouunt'])->withInput();
        }

        $hashed_value = $request->hash_value;
        $to_user = $user;
        $amount = $request->amount;
        $description = $request->description;

        return view('frontend.transferConfirm' , compact('auth_user','amount','description','to_user','hashed_value'));
    }

    public function checkToPhone(Request $request){
        $user = User::where('phone',$request->phone)->first();
        $auth_user = Auth::user();
        if($user){
            if($request->phone == $auth_user->phone){
                return response()->json([
                    'status' => 'fail',
                    'data' => 'Your own account'
                ]);
            }

            return response()->json([
                'status' => 'success',
                'data' => $user->name
            ]);
        }

        return response()->json([
            'status' => 'fail',
            'data' => 'To information not found'
        ]);
    }

    public function transferPasswordCheck(Request $request){
        $user = Auth::user();
        if(Hash::check($request->password, $user->password)){
            return response()->json([
                'status' => 'success',
            ]);
        }

        return response()->json([
            'status' => 'fail',
        ]);
    }

    public function transferFinal(TransferValidate $request){
        //hashed check
        $to_be_hashed = $request->to_phone . $request->amount . $request->description;
        $hashed_value2 = hash_hmac("sha256", $to_be_hashed ,'magipay123#@!') ;
        if($hashed_value2 !== $request->hashed_value){
            return redirect('/transfer')->withErrors(['to_phone'=>'Some Issue Exists']);
        }


        $user = User::where('phone',$request->to_phone)->first();


        if(!$user){
            return redirect('/transfer')->withErrors(['to_phone'=>'To information not found']);
        }

        $from_user = Auth::user();
        if($request->to_phone == $from_user->phone){
            return redirect('/transfer')->withErrors(['to_phone'=>'Cannot transfer to your own accouunt']);
        }

        if($from_user->wallets->amount < $request->amount){
            return redirect('/transfer')->withErrors(['amount'=>'Dont have enough cash']);
        }

        $to_user = $user;
        $amount = $request->amount;
        $description = $request->description;

        if(!$to_user->wallets || !$from_user->wallets){
            return back('/transfer')->withErrors(['to_phone'=>'Something Wrong']);
        }


        try {
            DB::beginTransaction();
            //increment and decrement
            $from_account_wallet = $from_user->wallets;
            $from_account_wallet->decrement('amount',$amount);
            $from_account_wallet->update();

            $to_account_wallet = $to_user->wallets;
            $to_account_wallet->increment('amount',$amount);
            $to_account_wallet->update();



            //transfer
            $refNo = UUIDGenerate::refNumber();


             $from_new_transation = Transaction::create([
                'ref_id' => $refNo,
                'transaction_id' => UUIDGenerate::transNumber(),
                'user_id' => $from_user->id,
                'type' => 2,
                'amount' => $amount,
                'source_id' => $user->id,
                'description' => $description ? $description : ''
            ]
            );

            $to_new_transation = Transaction::create([
                'ref_id' => $refNo,
                'transaction_id' => UUIDGenerate::transNumber(),
                'user_id' => $user->id,
                'type' => 1,
                'amount' => $amount,
                'source_id' => $from_user->id,
                'description' =>  $description ? $description : ''
            ]
            );

            //notification
            $title = 'Money Transfered !';
            $message = "Your have transfered ".number_format($amount)." MMK to ". $to_user->name ." (".$to_user->phone.") ";
            $sourceable_id = $from_user->id;
            $sourceable_type = Transaction::class;
            $web_link = url('/transaction_detials/'.$from_new_transation->transaction_id);
            Notification::send($from_user, new GeneralNotification($title, $message ,$sourceable_id  ,$sourceable_type ,$web_link));

            $title = 'Money Received !';
            $message =  "Your have received ".number_format($amount)." MMK from ". $from_user->name ." (".$from_user->phone.") ";
            $sourceable_id=$user->id;
            $sourceable_type = Transaction::class;
            $web_link = url('/transaction_detials/'.$to_new_transation->transaction_id);
            Notification::send($user, new GeneralNotification($title, $message ,$sourceable_id  ,$sourceable_type ,$web_link));



            DB::commit();

        return redirect('/transaction_detials/'.$from_new_transation->transaction_id)->with('success','Transfer Successfully');

          } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/transfer')->withErrors(['amount'=>$e]);
          }

    }

    public function transactionList(Request $request){
        $auth_user = Auth::user();

        $transactions = Transaction::where('user_id',$auth_user->id)->with('source')->orderBy('created_at','DESC');

        if($request->type){
            if($request->type == 1 || $request->type == 2){
                $transactions = $transactions->where('type',$request->type);
                // return view('frontend.transactionList',compact('transactions'));
            }
        }

        if($request->date){
            // dd($request->date);
            $transactions = $transactions->whereDate('created_at',$request->date);
            // dd($transactions->get()->toArray());
        }

        $transactions = $transactions->get();

        return view('frontend.transactionList',compact('transactions'));
    }

    public function transactionDetials($trx_id){

        $auth_user = Auth::user();

        $transaction_datials = Transaction::with('user','source')->where('user_id',$auth_user->id)->where('transaction_id',$trx_id)->first();

        if(!$transaction_datials){
            return redirect('/transactions');
        }

        return view('frontend.transactionDetails',compact('transaction_datials'));
    }

    public function scannerQr(){
        $user = Auth::user();
        return view('frontend.scanner_qr',compact('user'));
    }

    public function sanAndPay(){
        return view('frontend.san_and_pay');
    }

    public function sanAndTransfer(Request $request){
        $to_user = User::where('phone',$request->to_phone)->first();
        if(!$to_user){
            return back()->with('error','Phone Number Not Found');
        }

        $from_user = Auth::user();
        if($from_user->phone == $request->to_phone){
            return back()->with('error','Cannot Transfer To Own Phone');
        }



        return view('frontend.scan_and_transfer',compact('from_user','to_user'));
    }
}
