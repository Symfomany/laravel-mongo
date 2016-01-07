<?php

/**
 * Class BaseTestCase to add configuration of Laravel
 */
class BaseTestCase extends Orchestra\Testbench\TestCase {

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            'Mongo\Mongodb\MongodbServiceProvider',
            'Mongo\Mongodb\Auth\PasswordResetServiceProvider'
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  Illuminate\Foundation\Application    $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $config = require __DIR__.'/config/database.php';


        $app['config']->set('database.default', 'mongodb');
        $app['config']->set('database.connections.mysql', $config['connections']['mysql']);
        $app['config']->set('database.connections.mongodb', $config['connections']['mongodb']);

        $app['config']->set('auth.providers.users.model', 'User');
        $app['config']->set('cache.driver', 'array');

    }
}