<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //register
    public function register(Request $request){
        //validation
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required','unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);


        if ($validator->fails()) {
            return api_fail('failed',$validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $user->ip = $request->ip();
        $user->login_at = date('Y-m-d H:i:s');
        $user->user_agent =$request->server('HTTP_USER_AGENT');
        $user->update();

        $token = $user->createToken('Magic Pay')->accessToken;

        return api_success('Successfully Register' , [
            'token' => $token,
            'user' => $user
        ]);
    }

    //login
    public function login(Request $request){
        //validation
        $validator = Validator::make($request->all(), [
            'phone' => ['required'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return api_fail('failed',$validator->errors());
        }

        $user = User::where('phone',$request->phone)->first();
        if($user){
            $credentials = [
                'phone' => $request->phone,
                'password' => $request->password,
            ];

            if (Auth::attempt($credentials)) {
                $user->ip = $request->ip();
                $user->login_at = date('Y-m-d H:i:s');
                $user->user_agent =$request->server('HTTP_USER_AGENT');
                $user->update();

                $token = $user->createToken('Magic Pay')->accessToken;
                return api_success('Succecssfully login' , [
                    'token' => $token,
                    'user' => $user
                ]);
            }else{
                return api_fail('Failed login' , [
                    'errors' => 'Incorrect password'
                ]);
            }
        }else{
            return api_fail('Login Failed',[
                'errors' => 'No Phone Number Fouund'
            ]);
        }
    }
}
