<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request){
        $user = User::where('email',$request->email)->first();
        if(isset($user)){
            if($user->is_blocked == 0){
                if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
                    $user['token'] = $user->createToken('FaturaApp')->accessToken;
                    return response()->json(['status' => 'success', 'data' => $user]);

                }
            }else{
                return response()->json(['status' => 'error', 'data' => 'Your account has been blocked,Please check our policies']);
            }
        }else{
            return response()->json(['status' => 'error', 'data' => 'There is no account associated with this email']);
        }

    }

    public function logout(){
        if(Auth::check()){
            Auth::user()->token()->revoke();
            return response()->json(['status' => 'success', 'data' => 'You logged out successfully']);
        }else{
            return response()->json(['status' => 'success', 'data' => 'You already logged out']);

        }

    }
}
