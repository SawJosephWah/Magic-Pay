<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function home(){
        return view('backend.home');
    }

    public function adminLogout(){
        Auth::logout();
    }
}
