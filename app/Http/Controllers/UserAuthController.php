<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    //
    function login(Request $request){

        //return "login function";
        $user=User::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['success' => false, 'msg' => 'Invalid credentials'], 401);
        }
        $token = $user->createToken('MyApp')->plainTextToken;
        return response()->json(['success' => true, 'token' => $token, 'msg' => 'Login successful']);

    }


    function signup(Request $request){

        //return "signup function";
        $inputs=$request->all();
        $inputs['password']=bcrypt($inputs['password']);
        $user = User::create($inputs);
        $sucess['token']=$user->createToken('MyApp')->plainTextToken;
        $user['name']=$user->name;
        return['success' => true, 'token' => $sucess['token'], 'msg' => 'user created successfully']; 
        

    }
}
