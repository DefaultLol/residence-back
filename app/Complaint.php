<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $guarded=[];

    public function user(){
        return $this->belongsTo(User::class);
    }


    public function toggleResolved(){
        $this->update([
            'resolved'=>!$this->resolved
        ]);
    }
}
