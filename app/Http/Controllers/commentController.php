<?php

namespace App\Http\Controllers;
use App\comment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class commentController extends Controller
{
    //

    public function addcomment(Request $request){
        $nameImages=[];
        $comment =new comment();
        $comment->bodycomment=$request->input('commentbody');
        $comment->id_user=auth()->user()->id;
        $comment->id_post=$request->input('postid');

        if($request->hasFile('imagescomment')){
            $files=$request->file('imagescomment');
            foreach ($files as $file){
                $filename=$file->getClientOriginalName();
                $filename=time().'.'.$filename;
                $file->move('publicimages/',$filename);
                array_push($nameImages,$filename);
            }
            $comment->imagecomment=implode(',',$nameImages);
        }

        $comment->save();
        return view('/ask');
    }
    public function  showdatacomment($id){
        $allpost= DB::table('users')->join('posts','posts.id_user','=','users.id')->select('users.*','posts.*')->get();
        $allcomment= DB::table('comments')
            ->join('posts','posts.id','=','comments.id_post')
            ->where('posts.id','=',$id)
            ->join('users','comments.id_user','=','users.id')
            ->select('users.*','comments.*','posts.*')->get();
        $numcomment=count($allcomment);

        return view('/ask',compact('allcomment','allpost','numcomment'));
    }
    public function  readData(){
        $allcomment= DB::table('comments')->join('posts','comments.id_post','=','posts.id')->join('users','comments.id_user','users.id')->
        select('users.*','comments.*','posts.*')->get();
        return response($allcomment);
    }
}
