<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ProfileController extends Controller
{
    public function edit(Request $request){
        $data=$request->validate([
            'firstName'=>'required',
            'lastName'=>'required',
            'phone'=>'required',
            'appart_number'=>'required',
            'parking_number'=>'required',
        ]);
        $id = auth()->user()->id;
        $user=auth()->user();
        $user->firstName=$request->firstName;
        $user->lastName=$request->lastName;
        $user->phone=$request->phone;
        $user->appart_number=$request->appart_number;
        $user->parking_number=$request->parking_number;
        if ($request->picture!=null){
            $fileName = $this->uploadImage($request);
            $user->avatar=$fileName;
        }
        $user->save();
        $user=User::find($id);
        return response()->json(['user'=>$user],200);
    }

    public function uploadImage(Request $request){
        $name=time().'.'.'png';
        $image=$this->base64ToImage($request->picture,$name);
        move_uploaded_file($image,public_path('avatares/'));
        return $name;
    }

    public function base64ToImage($base64_string, $output_file) {
        $file = fopen($output_file, "wb");
        fwrite($file, base64_decode($base64_string));
        fclose($file);
        return $output_file;
    }
}
