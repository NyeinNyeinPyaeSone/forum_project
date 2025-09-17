<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Thread;
use Illuminate\Http\Request;

class CommentController extends Controller
{
        

    public function store(Thread $thread){
        
        
        request()->validate([
            'body' => 'required'
        ]);
       
        $thread->comments()->create([
            'user_id' => auth()->id(),
            'body' => request('body'),
        ]);
        return back();


    }

    public function update(Comment $comment){
        
        
        request()->validate([
            'body' => 'required'
        ]);
       
        $comment->body = request('body');
        $comment->save();
        return back();


    }

    public function destroy(Comment $comment){
        $comment->delete();
        return back();
    }
}
