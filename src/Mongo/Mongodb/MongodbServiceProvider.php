<?php

namespace Mongo\Mongodb;

use Illuminate\Support\ServiceProvider;

/**
 * Class Connection
 */
class MongodbServiceProvider extends ServiceProvider{

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        Model::setConnectionResolver($this->app['db']);

        Model::setEventDispatcher($this->app['events']);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        //when resolving connection to database
        $this->app->resolving('db', function ($db)
        {
            // extend DB object, add mongodb
            $db->extend('mongodb', function ($config)
            {

                return new Connection($config);
            });
        });
    }



}