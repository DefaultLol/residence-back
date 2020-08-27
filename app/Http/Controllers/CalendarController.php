<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CalendarController extends Controller
{
    //get articles with event category
    public function index()
    {
        //get category id by name of Event
        $category_id=Category::where('name','Event')->get()[0]->id;
        //get articles with specific category id of Event
        $articles=Article::with('user','tags')->where('category_id',$category_id)
            ->orderBy('creation_date','asc')->get();
        //produce a unique array of created at
        $data=$articles->pluck('creation_date');
        $dates=$data->unique()->all();
        $uniqueDate=array();
        $array=array();
        foreach($dates as $key){
            $keyData=array();
            foreach($articles as $article){
                if($this->compareDates($key,$article->creation_date)){
                    array_push($keyData,$article);
                }
            }
            $array=Arr::add($array,$key.'',$keyData);
        }

        return response()->json(['events'=>$array,'firstDate'=>$articles[0]->creation_date],200);
    }

    public function convertDate($date){
        $newtime = strtotime($date);
        return date('Y-m-d',$newtime);
    }

    public function compareDates($date1,$date2){
        return $date1==$date2;
    }
}
