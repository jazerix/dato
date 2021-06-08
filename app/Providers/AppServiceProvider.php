<?php

namespace App\Providers;

use App\Models\Player;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \View::composer('admin', function(View $view) {
           $view->with('players', Player::orderBy('name')->get());
        });
    }
}
