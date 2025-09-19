<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ThreadController extends Controller
{
    public function index() {
        
        // dd(Thread::with('category','user')->filter(request(['category', 'tag','search']))->latest()->get()->map(
        //     function($thread){
        //         $thread->threadActionAuthorized = auth()->user()?->can('threadActionAuthorized', $thread);
        //         return $thread;
        //     })->toArray());
        return inertia('Welcome', [
            'threads' => Inertia::deepMerge(
                Thread::with('category','user')
                    ->filter(request(['category', 'tag','search', 'popular', 'followed']))
                    ->latest()
                    ->paginate(5)
                    ->through(function($thread) {
                        $thread->threadActionAuthorized = auth()->user()?->can('threadActionAuthorized', $thread);
                        return $thread;
                    })
            )
        ]);
    }
    

    public function show(Thread $thread){
        
        return inertia("threads/show", [
            'thread' => fn() => $thread->load(['category','user']),
            'comments' => fn() => $thread->comments()->with('user')->latest()->get()->map(
                function($comment){
                    $comment->commentActionAuthorized = auth()->user()?->can('commentActionAuthorized', $comment);
                    return $comment;
                })
        ]);
    }

    public function create() {
        return inertia('threads/ThreadForm' , [
        ]);
    }

    public function edit(Thread $thread){
        return inertia('threads/ThreadForm', [
            'thread' => $thread->load('tags')
        ]);
    }

    public function update(Thread $thread){
        
        request()->validate([
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required|numeric',
        ], [
            'category_id.required' => 'Please select a category.'
        ]);
        
        
        $thread->title = request('title');
        $thread->body = request('body');
        $thread->category_id = request('category_id');
        $thread->user_id = auth()->id();
        $thread->save();
        $thread->tags()->detach();
        $thread->tags()->attach(request('tag_ids'));
        return redirect('/');
       
    }

    public function store(){
        
        request()->validate([
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required|numeric',
        ], [
            'category_id.required' => 'Please select a category.'
        ]);
        
        $thread = new Thread();
        $thread->title = request('title');
        $thread->body = request('body');
        $thread->category_id = request('category_id');
        $thread->user_id = auth()->id();
        $thread->save();
        $thread->tags()->attach(request('tag_ids'));
        return redirect('/');
       
    }

    

    public function destroy(Thread $thread){
        $thread->delete();
        return back();
    }

    
}
