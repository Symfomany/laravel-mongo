<?php

/**
 * Class SeederTest
 */
class SeederTest extends BaseTestCase {

    public function tearDown()
    {
        User::truncate();
    }

    public function testSeed()
    {
        $seeder = new UserTableSeeder;
        $seeder->run();
        $user = User::where('name', 'John Doe')->first();
        $this->assertTrue($user->seed);
    }


}