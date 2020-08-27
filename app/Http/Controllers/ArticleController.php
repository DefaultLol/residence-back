<?php

namespace App\Http\Controllers;

use App\Article;
use App\Events\General;
use App\User;
use App\Tag;
use App\Notification;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        return Article::with('tags','user','category','likes')->orderBy('created_at','desc')-> get();
    }

    public function store(Request $request)
    {
        $this->validateArticle($request);
        $fileName = $this->uploadImage($request);
        $article=Article::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'creation_date'=>$request->creation_date,
            'user_id' => auth()->user()->id,
            'content' => $request->information,
            'picture' => $fileName,
            'position' => $request->position,
            'description' => $request->description,
            'keywoard' => $request->keywoard
        ]);
        $this->tagOp($request,$article);
        $users=User::all();
        $id=auth()->user()->id;
        foreach($users as $user){
            if(!($user->id == $id)){
                $this->createNotification($id,$user->id,'Admin just posted an article');
            }
        }
        $article=Article::with('tags','user','category','likes')->where('id',$article->id)->get();
        event(new General('lol','test'));
        return response()->json(['message'=>'data inserted succefully','article'=>$article],200);
    }

    public function show(Article $article)
    {
        return response()->json(['article'=>$article]);
    }

    public function update(Request $request,Article $article)
    {
        $this->validateArticle($request);
        if($request->picture){
            $fileName = $this->uploadImage($request);
        }
        else{
            $fileName = $article->picture;
        }
        $article->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'creation_date'=>$request->creation_date,
            'content' => $request->information,
            'picture' => $fileName,
            'position' => $request->position,
            'description' => $request->description,
            'keywoard' => $request->keywoard
        ]);
        $article->tags()->detach();
        $this->tagOp($request,$article);
        return response()->json(['message'=>'Updated Succefully']);
    }

    public function destroy(Article $article)
    {
        $article->tags()->detach();
        $article->delete();
        return response()->json(['message'=>'Deleted Succefully']);
    }

    //helper functions
    public function validateArticle(Request $request){
        $request->validate([
            'title'=>'required',
            'category_id'=>'required',
            'information'=>'required',
            'position'=>'required',
            'description'=>'required',
            'keywoard'=>'required',
            'tags' => 'required'
        ]);
    }

    public function tagOp(Request $request,$article){
        $tags=json_decode($request->tags);
        foreach($tags as $tag){
            $data=Tag::where('name',$tag)->first();
            if(!Tag::where('name',$tag)->exists()){
                $data=Tag::create([
                    'name'=>$tag
                ]);
            }
            $article->tags()->attach($data->id);
        }
    }

    public function uploadImage(Request $request){
        $name=time().'.'.'png';
        $image=$this->base64ToImage($request->picture,$name);
        move_uploaded_file($image,public_path('avatares/'));
        return $name;
    }

    public function base64ToImage($base64_string, $output_file) {
        $file = fopen($output_file, "wb");
        fwrite($file, base64_decode($base64_string));
        fclose($file);
        return $output_file;
    }

    public function createNotification($sender,$receiver,$body){
        Notification::create([
            'sender_id'=>$sender,
            'receiver_id'=>$receiver,
            'body'=>$body
        ]);
    }
}
