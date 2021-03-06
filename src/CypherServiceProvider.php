<?php

namespace Ahsan\Cypher;

use Ahsan\Cypher\Cypher;
use Illuminate\Support\ServiceProvider;

class CypherServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
    * Bootstrap the application events.
    *
    * @return void
    */
    public function boot()
    {
        //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('cypher', function ($app) {
            return new Cypher();
        });
    }
}
