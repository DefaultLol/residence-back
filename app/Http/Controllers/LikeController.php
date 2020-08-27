<?php

namespace App\Http\Controllers;

use App\Article;
use App\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like($id)
    {
        $article=Article::find($id);
        $likes=Like::where('article_id',$id)->where('user_id',auth()->user()->id)->get();
        if(sizeof($likes)==0){
            $article->increment('likes_count');
        }
        else{
            if($likes[0]->liked==0){
                $article->increment('likes_count');
                $article->decrement('dislikes_count');
            }
        }
        $article->like();
        return Article::with('tags','user','category','likes')->orderBy('created_at','desc')-> get();
    }

    public function dislike($id)
    {
        $article=Article::find($id);
        $likes=Like::where('article_id',$id)->where('user_id',auth()->user()->id)->get();
        if(sizeof($likes)==0){
            $article->increment('dislikes_count');
        }
        else{
            if($likes[0]->liked==1){
                $article->increment('dislikes_count');
                $article->decrement('likes_count');
            }
        }
        $article->dislike();
        return Article::with('tags','user','category','likes')->orderBy('created_at','desc')-> get();
    }
}
