<?php

namespace App\Http\Controllers;

use App\Article;
use App\Events\Comments;
use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function index($id)
    {
        return Comment::where('article_id',$id)->with('user','article')->orderBy('created_at','asc')-> get();
    }

    public function save(Request $request,$id)
    {
        $article=Article::find($id);
        $article->comments()->create(['user_id'=>auth()->user()->id,'body'=>$request->body]);
        event(new Comments($id,auth()->user()->id));
        return $this->index($id);
    }
}
