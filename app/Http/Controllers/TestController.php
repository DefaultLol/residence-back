<?php

namespace App\Http\Controllers;

use App\Events\testEvent;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(){
        event(new testEvent('hello world'));
        return 'event sucess';
    }
}
