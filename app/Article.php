<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded=[];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function like($user=null,$liked=true){
        return $this->likes()->updateOrCreate(
            [
                'user_id'=>$user ? $user->id : auth()->user()->id
            ],
            [
                'liked'=>$liked
            ]
        );
    }

    public function dislike($user=null,$liked=false){
        return $this->like($user,$liked);
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
