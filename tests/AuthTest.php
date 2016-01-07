<?php

use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Support\Facades\Auth;

class AuthTest extends BaseTestCase {

    public function tearDown()
    {
        User::truncate();
        DB::collection('password_reminders')->truncate();
    }
    public function testAuthAttempt()
    {
        User::create([
            'name'     => 'John Doe',
            'email'    => 'john@doe.com',
            'password' => Hash::make('foobar'),
        ]);
        $this->assertTrue(Auth::attempt(['email' => 'john@doe.com', 'password' => 'foobar'], true));
        $this->assertTrue(Auth::check());
    }

}