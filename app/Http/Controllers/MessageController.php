<?php

namespace App\Http\Controllers;

use App\Events\Messages;
use App\Events\Notifications;
use App\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public $sender;
    public $receiver;
    public function index($id)
    {
        $this->sender=auth()->user()->id;
        $this->receiver=$id;
        $data=Message::where(function($query){
            $query->where('sender_id','=',$this->sender)->where('receiver_id','=',$this->receiver);
        })->orWhere(function($q){
            $q->where('sender_id','=',$this->receiver)->where('receiver_id','=',$this->sender);
        })->orderBy('created_at','asc')->get();

        return response()->json($data);
    }

    public function save(Request $request)
    {
        $message=Message::create([
            'sender_id'=>auth()->user()->id,
            'receiver_id'=>$request->receiver_id,
            'body'=>$request->body
        ]);
        $senderName=auth()->user()->firstName.' '.auth()->user()->lastName;
        event(new Messages($message->body,$message->receiver_id,$message->sender_id,$message));
        event(new Notifications('Message Received',$senderName.' sent you a message !',$message->receiver_id));
        return response()->json($message);
    }
}
