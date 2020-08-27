<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){
        $user=$request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);
        if(!auth()->attempt($user)){
            return response()->json(['message'=>'Error in inputs'],400);
        }
        $token = auth()->user()->createToken('Token Name')->accessToken;

        return response()->json(['token'=>$token,'user'=>auth()->user()]);
    }

    public function register(Request $request){
        $user=$request->validate([
            'firstName'=>'required',
            'lastName'=>'required',
            'email'=>'required',
            'password'=>'required',
            'phone'=>'required',
            'appart_number'=>'required',
            'parking_number'=>'required'
        ]);

        User::create([
            'firstName'=>$request->firstName,
            'lastName'=>$request->lastName,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'phone'=>$request->phone,
            'appart_number'=>$request->appart_number,
            'parking_number'=>$request->parking_number,
            'role'=>'basic'
        ]);
        return response()->json(['user'=>$user,'message'=>'Succefully registered'],200);

    }

    public function me(Request $request){
        return response()->json(['user' => auth()->user()]);
    }
}
