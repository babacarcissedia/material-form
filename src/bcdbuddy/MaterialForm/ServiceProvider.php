<?php

namespace bcdbuddy\MaterialForm;

use bcdbuddy\MaterialForm\MaterialForm;
use bcdbuddy\MaterialForm\ErrorStore\IlluminateErrorStore;
use bcdbuddy\MaterialForm\OldInput\IlluminateOldInputProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Class PackageServiceProvider
 *
 * @package bcdbuddy\MaterialForm
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('material-form', function ($app) {

            $builder = new MaterialForm();
            $builder->setToken($app['session.store']->token());
            $builder->setErrorStore(new IlluminateErrorStore($app['session.store']));
            $builder->setOldInputProvider(new IlluminateOldInputProvider($app['session.store']));

            return $builder;
        });
    }

    /**
     * Application is booting
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(realpath(__DIR__.'/../resources/views/'), 'material-form');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['material-form'];
    }
}
