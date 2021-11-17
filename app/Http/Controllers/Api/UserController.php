<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use function Symfony\Component\String\b;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:10'
        ]);

            $user = $this->registerProcess($request);
            return response()->json(['status' => 'success', 'data' => $user]);

    }

    private function registerProcess(Request $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $user['token'] = $user->createToken('FaturaApp')->accessToken;
        $role = Role::where('name','User')->first();
        $user->assignRole($role);

        return $user;
    }


    public function profile(){
        $user = auth()->user();

        if($user->is_blocked == 0){
            return response()->json(['status' => 'success', 'data' => $user]);

        }else{
            return response()->json(['status' => 'error', 'data' => 'Your account has been blocked,Please check our policies']);

        }
    }







}
