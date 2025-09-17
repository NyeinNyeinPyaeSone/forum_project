<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();
        Vite::prefetch(concurrency: 3);
        Gate::define('threadActionAuthorized', function (User $user, Thread $thread) {
            return $user->id === $thread->user_id;
        });
        Gate::define('commentActionAuthorized', function (User $user, Comment $comment) {
            return $user->id === $comment->user_id;
        });
    }

    
}
