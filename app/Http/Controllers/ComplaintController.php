<?php

namespace App\Http\Controllers;

use App\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        return response()->json(Complaint::with('user')->orderBy('created_at','desc')->get(),200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'body'=>'required'
        ]);
        $data=['user_id'=>auth()->user()->id,'body'=>$request->body];
        $createdData=Complaint::create($data);
        $complaint=Complaint::with('user')->find($createdData->id);
        return response()->json($complaint,200);
    }

    public function update(Request $request,Complaint $complaint)
    {
        $data=$request->validate([
            'body'=>'required'
        ]);
        $complaint->update($data);
        $newComplaint=Complaint::with('user')->find($complaint->id);
        return response()->json($newComplaint,200);
    }

    public function destroy(Complaint $complaint)
    {
        $complaint->delete();
        return response()->json(['message'=>'deleted succefully'],200);
    }

    public function resolveToggle(Camplaint $complaint){
        return $complaint;
    }
}
