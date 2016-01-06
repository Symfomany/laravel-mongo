<?php


class ConnectionTest extends BaseTestCase {


    public function setUp()
    {
        parent::setUp();
    }


    public function tearDown()
    {
        $connection = DB::connection('mongodb');
        $db = $connection->getDatabase('testing');
        $db->drop(); //drop database
    }


    public function testDatabase()
    {

        $connection = DB::connection('mongodb');

        $db = $connection->getDatabase('testing');
        $db->drop(); //drop database

        $this->assertInstanceOf('Mongo\Mongodb\Database', $db);
        $this->assertEquals($db->getName(), "testing");
        $db->dropCollection('articles');

        $response = $db->createCollection('articles');
        $this->assertEquals($response->ok, "1.0");
    }

    public function  testCreateCollection()
    {
        $connection = DB::connection('mongodb');
        $db = $connection->getDatabase('testing');
        $db->dropCollection('articles');
        $response  = $db->createCollection('articles');
        $this->assertEquals($response->ok, "1.0");
    }


    public function testConnection()
    {
        $connection = DB::connection('mongodb');
        $this->assertInstanceOf('Mongo\Mongodb\Connection', $connection);
    }

    public function testReconnect()
    {
        $c1 = DB::connection('mongodb');
        $c2 = DB::connection('mongodb');
        $this->assertEquals(spl_object_hash($c1), spl_object_hash($c2));

        $c1 = DB::connection('mongodb');
        DB::purge('mongodb');
        $c2 = DB::connection('mongodb');
        $this->assertNotEquals(spl_object_hash($c1), spl_object_hash($c2));
    }

    public function testDb()
    {
        $connection = \Illuminate\Support\Facades\DB::connection('mongodb');
        $this->assertEquals("testing", $connection->getMongoDB());

    }


    public function testDriverName()
    {
        $driver = DB::connection('mongodb')->getDriverName();
        $this->assertEquals('mongodb', $driver);
    }

    public function testCustomPort()
    {
        $port = 27017;
        Config::set('database.connections.mongodb.port', $port);
        $host = Config::get('database.connections.mongodb.host');
        $database = Config::get('database.connections.mongodb.database');
        $connection = DB::connection('mongodb');
    }
    public function testHostWithPorts()
    {
        $hosts = ['localhost:27017'];
        Config::set('database.connections.mongodb.port', 27017);
        Config::set('database.connections.mongodb.host', ['localhost:27017']);
        $database = Config::get('database.connections.mongodb.database');
        $connection = DB::connection('mongodb');
    }




}