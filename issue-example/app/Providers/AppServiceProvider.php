<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\IssueRepository\IssueRepository;
use App\Repositories\IssueRepository\EloquentIssue;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\IssueRepository\IssueRepositoryInterface', 'App\Repositories\IssueRepository\IssueRepository');
        $this->app->bind('App\Repositories\IssueNoteRepository\IssueNoteRepositoryInterface', 'App\Repositories\IssueNoteRepository\IssueNoteRepository');

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'Order' => 'App\Models\Order',
            'Product' => 'App\Models\Order',
        ]);
    }
}
