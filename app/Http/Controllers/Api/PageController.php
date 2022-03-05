<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Transaction;
use Illuminate\Http\Request;
use App\Helpers\UUIDGenerate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Notifications;
use App\Http\Requests\TransferValidate;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\TransactionDetails;
use App\Notifications\GeneralNotification;
use App\Http\Resources\NotificationDetails;
use App\Http\Resources\TransactionResource;
use Illuminate\Support\Facades\Notification;

class PageController extends Controller
{
    public function profile(){
        $auth_user = Auth::user();
        $data = new ProfileResource($auth_user);
        return api_success('Profile',$data);
    }

    public function logout(Request $request){
        // return 'here';
        $user = $request->user()->token();
        $user->revoke();
        return api_success('Successfully Logout','Logout');
    }

    public function transactions(Request $request){
        $auth_user = Auth::user();
        $transactions = Transaction::where('user_id',$auth_user->id)->with('source')->orderBy('created_at','DESC');

        if($request->date){
            $transactions->whereDate('created_at', $request->date);
        }

        if($request->type){
            $transactions->where('type', $request->type);
        }

        $transactions = $transactions->paginate(5);

        $data = TransactionResource::collection($transactions)->additional(['status' => 1,'message' => 'Transactions']);

        return $data;
    }

    public function transactionDetails($id){
        $auth_user = Auth::user();

        $transaction = Transaction::with('source')->where('transaction_id',$id)->where('user_id',$auth_user->id)->first();

        $data = new TransactionDetails($transaction);

        return api_success('Transaction Details' , $data);

    }

    public function notifications(){
        $auth_user = Auth::user();

        $user = User::find($auth_user->id);

        $notifications = $user->notifications()->paginate(5);

        $data = Notifications::collection($notifications);

        return $data;
    }

    public function  notificationDetails($id){
        $auth_user = Auth::user();

        $notification = $auth_user->notifications->where('id')->first();

        $data = new NotificationDetails($notification);

        return api_success('Notification Details',$data);
    }

    public function verifyPhone(Request $request){
        $auth_user = Auth::user();
        if($request->phone){
            $user = User::where('phone', $request->phone)->first();
            if($user){
                if($user->phone != $auth_user->phone){
                    return api_fail('Verify Phone Number' , [
                        'name' => $user->name,
                        'phone' => $user->phone]);
                }else{
                    return api_fail('Verify Phone Number' ,'Your Own Phone Number');
                }
            }else{
                    return api_fail('Verify Phone Number' ,'Phone Number Not Found');
            }

        }

        return api_fail('Error','Something Error');
    }

    public function transferConfirm(TransferValidate $request){
        $to_be_hashed = $request->to_phone . $request->amount . $request->description;
        $hashed_value2 = hash_hmac("sha256", $to_be_hashed ,'magipay123#@!') ;
        if($hashed_value2 !== $request->hash_value){
            // return redirect('/transfer')->withErrors(['to_phone'=>'Some Issue Exists'])->withInput();
            return api_fail('Some Issue Exists! Try Again',null);
        }


        $user = User::where('phone',$request->to_phone)->first();
        $auth_user = Auth::user();


        if($request->amount > $auth_user->wallets->amount){
            // return redirect('/transfer')->withErrors(['amount'=>'Dont have enough cash'])->withInput();
            return api_fail('Dont have enough cash',null);
        }

        if(!$user){
            // return redirect('/transfer')->withErrors(['to_phone'=>'To information not found'])->withInput();
            return api_fail('To information not found',null);
        }


        if($request->to_phone == $auth_user->phone){
            // return redirect('/transfer')->withErrors(['to_phone'=>'Cannot transfer to your own accouunt'])->withInput();
            return api_fail('Cannot transfer to your own accouunt',null);
        }

        $hashed_value = $request->hash_value;
        $to_user = $user;
        $amount = $request->amount;
        $description = $request->description;

        // return view('frontend.transferConfirm' , compact('auth_user','amount','description','to_user','hashed_value'));
        return api_success('Transfer Confirm',[
            'from_user'=> $auth_user,
            'to_user'=>$to_user,
            'amount'=>$amount,
            'description'=>$description,
            'hashed_value'=>$hashed_value
        ]);
    }

    public function transferFinal(TransferValidate $request){
         //hashed check
         $to_be_hashed = $request->to_phone . $request->amount . $request->description;
         $hashed_value2 = hash_hmac("sha256", $to_be_hashed ,'magipay123#@!') ;
         if($hashed_value2 !== $request->hashed_value){

             return api_fail('Some Issue Exists! Try Again',null);
         }


         $user = User::where('phone',$request->to_phone)->first();


         if(!$user){

             return api_fail('To information not found',null);
         }

         $from_user = Auth::user();
         if($request->to_phone == $from_user->phone){

             return api_fail('Cannot transfer to your own accouunt',null);
         }

         if($from_user->wallets->amount < $request->amount){

             return api_fail('Dont have enough cash',null);
         }

         $to_user = $user;
         $amount = $request->amount;
         $description = $request->description;

         if(!$to_user->wallets || !$from_user->wallets){

             return api_fail('Something Wrong',null);
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

             //notifications
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


         return api_success('Transfer Complete',[
             'trx_id' => $from_new_transation->transaction_id
         ]);

           } catch (\Exception $e) {
             DB::rollBack();

             return api_fail('Errors',$e);
           }

    }

}
