<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider {

    public function boot() {
        \Auth::extend('social', function($app) {
            return new SocialUserProvider($app['hash'], $app['config']['auth.model']);
        });
    }

    public function register() { }
}
