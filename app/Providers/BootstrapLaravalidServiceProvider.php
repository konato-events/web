<?php
namespace App\Providers;

use Collective\Html\HtmlBuilder;
use LaravelArdent\Laravalid\LaravalidServiceProvider;
use Resources\BootstrapFormBuilder as FormBuilder;

class BootstrapLaravalidServiceProvider extends LaravalidServiceProvider {

    public function register() {
        $this->registerResources();

        if (!isset($this->app['html'])) {
            $this->app->bindShared('html', function ($app) {
                return new HtmlBuilder($app['url']);
            });
        }

        $this->app->bindShared('laravalid', function ($app) {
            /** @var \Illuminate\Contracts\Foundation\Application $app */
            $plugin             = \Config::get('laravalid.plugin');
            $converterClassName = 'LaravelArdent\Laravalid\Converter\\'.$plugin.'\Converter';
            $converter          = new $converterClassName();

            $form = new FormBuilder($app->make('html'), $app->make('url'), $app->make('session.store')->getToken(),
                $converter);
            return $form->setSessionStore($app->make('session.store'));
        });
    }
}
