<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;


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
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        view()->composer('*', function ($view) {
            $view->with('getSearchAction', function ($routeName) {
                switch ($routeName) {
                    case 'my.posts':
                    case 'createPost':
                        return route('my.posts');
                    case 'jobs.search':
                        return route('jobs.search');
                    case 'statistics':
                        return route('statistics');
                    case 'graphType1':
                        return route('graphType1');
                    case 'admin.jobs.indexDescriptions':
                        return route('admin.jobs.indexDescriptions');
                    default:
                        return route('index');
                }
            });


            $view->with('getSearchPlaceholder', function ($routeName) {
                switch ($routeName) {
                    case 'my.posts':
                    case 'createPost':
                        return trans('messages.user.search_job_listings');
                    case 'jobs.search':
                        return trans('messages.user.search_jobs');
                    case 'statistics':
                        return trans('messages.user.search_cartesian');
                    case 'graphType1':
                        return trans('messages.user.search_pie');
                    default:
                        return trans('messages.misc.search');
                }
            });
        });
    }
}
