<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['ref_id','transaction_id','user_id','type','amount','source_id','description'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function source()
    {
        return $this->belongsTo(User::class,'source_id','id');
    }
}
