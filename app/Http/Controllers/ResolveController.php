<?php

namespace App\Http\Controllers;

use App\Complaint;
use Illuminate\Http\Request;

class ResolveController extends Controller
{
    public function resolveToggle($id){
        $complaint=Complaint::find($id);
        $complaint->toggleResolved();
        return response()->json(['message'=>'Updated Succefully']);
    }
}
