<?php

/**
 * Class ValidatorTest
 */
class ValidationTest extends BaseTestCase {

    public function tearDown()
    {
        User::truncate();
    }


    public function testUnique()
    {
        $validator = Validator::make(
            ['name' => 'John Doe'],
            ['name' => 'required|unique:users']
        );
//        exit(dump($validator->fails()));
        $this->assertFalse($validator->fails());
        User::create(['name' => 'John Doe']);
        $validator = Validator::make(
            ['name' => 'John Doe'],
            ['name' => 'required|unique:users']
        );
        $this->assertTrue($validator->fails());
    }



}