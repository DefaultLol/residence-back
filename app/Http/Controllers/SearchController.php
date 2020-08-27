<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use App\User;

class SearchController extends Controller
{
    public $id;
    public $sender;
    public function getAll()
    {
        $result=[];
        $this->id=auth()->user()->id;
        $users=User::all();
        foreach($users as $user){
            $this->sender=$user->id;
            $lastmessage=Message::where(function($query){
                $query->where('sender_id','=',$this->sender)->where('receiver_id','=',$this->id);
            })->orWhere(function($q){
                $q->where('sender_id','=',$this->id)->where('receiver_id','=',$this->sender);
            })->orderBy('created_at','desc')->first();
            array_push($result,['user'=>$user,'last'=>$lastmessage]);
        }
        return response()->json($result,200);
    }

    public function index(Request $request){
        $name=$request->name;
        return response()->json(User::where('firstName','like','%'.$name.'%')->get());
    }

    public function promote($id){
        $user=User::find($id);
        $user->update([
            'role'=>'admin'
        ]);

        return response()->json(['message'=>'Succeffuly promoting to admin']);
    }

    public function suggestion(){
        $users=User::paginate(5);
        return response()->json($users);
    }

    public function searchMessage(Request $request){
        $name=$request->name;
        $result=[];
        $this->id=auth()->user()->id;
        $users=User::where('firstName','like','%'.$name.'%')->get();
        foreach($users as $user){
            $this->sender=$user->id;
            $lastmessage=Message::where(function($query){
                $query->where('sender_id','=',$this->sender)->where('receiver_id','=',$this->id);
            })->orWhere(function($q){
                $q->where('sender_id','=',$this->id)->where('receiver_id','=',$this->sender);
            })->orderBy('created_at','desc')->first();
            array_push($result,['user'=>$user,'last'=>$lastmessage]);
        }
        return response()->json($result,200);
    }

    public function revoke($id){
        $user=User::find($id);
        $user->update([
            'role'=>'basic'
        ]);

        return response()->json(['message'=>'Succeffuly revoked to basic']);
    }
}
