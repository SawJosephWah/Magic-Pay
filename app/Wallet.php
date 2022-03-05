<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = ['user_id','account_number','amount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
