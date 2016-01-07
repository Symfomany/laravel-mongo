<?php

use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Support\Facades\Auth;

class BuilderTest extends BaseTestCase {

    public function tearDown()
    {
        User::truncate();

    }

    public function testUpdate()
    {
        $user = DB::table('users')->insert(
            ['email' => 'john@example.com', 'votes' => 0]
        );

        DB::table('users')
            ->where('email', 'john@example.com')
            ->update(['votes' => 1]);

        $users = DB::table('users')->first();

        $this->assertEquals(1, $users->votes);

    }
    public function testInsert()
    {
        DB::table('users')->insert(
            ['email' => 'john@example.com', 'votes' => 0]
        );

        $users = DB::table('users')->first();

        $this->assertEquals(0, $users->votes);

    }

    public function testInsertGetId()
    {
        DB::table('users')->insert(
            ['email' => 'john@example.com', 'votes' => 0]
        );

        $users = DB::table('users')->first();

        $this->assertEquals(0, $users->votes);

    }

}