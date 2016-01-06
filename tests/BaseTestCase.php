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
            'Mongo\Mongodb\MongodbServiceProvider'
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
        //        $app['path.base'] = __DIR__ . '/../src';
        $config = require __DIR__.'/config/database.php';
        $app['config']->set('database.default', 'mongodb');
        $app['config']->set('database.connections.mysql', $config['connections']['mysql']);
        $app['config']->set('database.connections.mongodb', $config['connections']['mongodb']);

        $app['config']->set('cache.driver', 'array');
        $app['config']->set('auth.model', 'User');

    }
}