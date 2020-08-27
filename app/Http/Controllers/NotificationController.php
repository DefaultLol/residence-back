<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;

class NotificationController extends Controller
{
    public function index(){
        $id=auth()->user()->id;
        return response()->json(Notification::where('receiver_id',$id)->with('receiver','sender')->orderBy('created_at','desc')->get(),200);
    }

    public function delete($id){
        $notif=Notification::find($id);
        $notif->delete();
        return response()->json(['message'=>'succeffuly delete']);
    }
}
