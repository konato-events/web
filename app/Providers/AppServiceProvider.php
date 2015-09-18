<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        $view = view();
        $view->share('env', \App::environment());
        $view->share('prod', \App::environment('prod'));
        // add here global view variables using $view->share('key', 'value');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }
}
