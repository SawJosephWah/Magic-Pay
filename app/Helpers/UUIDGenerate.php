<?php
namespace App\Helpers;

use App\Transaction;
use App\Wallet;

class UUIDGenerate{
    public static function accountGenerate(){
        $account = mt_rand(1000000000000000,9999999999999999);

        if(Wallet::where('account_number',$account)->exists()){
            self::accountGenerate();
        };

        return $account;
    }

    public static function refNumber(){
        $number = mt_rand(1000000000000000,9999999999999999);

        if(Transaction::where('ref_id',$number)->exists()){
            self::refNumber();
        };

        return $number;
    }

    public static function transNumber(){
        $number = mt_rand(1000000000000000,9999999999999999);

        if(Transaction::where('transaction_id',$number)->exists()){
            self::transNumber();
        };

        return $number;
    }

}
?>
