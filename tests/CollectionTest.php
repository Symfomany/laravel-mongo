<?php


class CollectionTest extends BaseTestCase {


    public function setUp()
    {
        parent::setUp();

    }

    public function tearDown()
    {
        $connection = DB::connection('mongodb');
        $db = $connection->getDatabase('testing');
        $db->dropCollection('articles');
        $db->createCollection('articles');
        $collection = DB::connection('mongodb')->getCollection('articles');

        $collection->create([
            ['title' => 'Le petit yahourt rouge'],
            ['title' => 'Le petit berger blanc'],
            ['title' => 'Le petit berger blanc'],
        ]);
    }


    public function testCollection()
    {
        $connection = DB::connection('mongodb');
        $db = $connection->getDatabase('testing');
        $db->drop(); //drop database
        $db->dropCollection('articles');
        $db->createCollection('articles');

        $collection = DB::connection('mongodb')->getCollection('articles');
        $this->assertInstanceOf('Mongodb\Collection', $collection);
        $this->assertEquals(0, $collection->count());
    }


    public function testInsertCollection()
    {

        $collection = DB::connection('mongodb')->getCollection('articles');

        $insertresult  = $collection->create(['title' => 'Le petit fromage rouge']);
        $this->assertInstanceOf('MongoDB\InsertOneResult', $insertresult);
        $this->assertEquals(1, $insertresult->getInsertedCount());
        $this->assertEquals(4, $collection->count());

        $insertresultmultiple  = $collection->create([
            ['title' => 'Le petit voyage bleue'],
            ['title' => 'Le petit rendez-vous vert'],
        ]);


        $this->assertEquals(2, $insertresultmultiple->getInsertedCount());
        $this->assertEquals(6, $collection->count());

    }


    public function testUpdateCollection()
    {

        $collection = DB::connection('mongodb')->getCollection('articles');

        $updateresult  = $collection->update(['title' => 'Le petit yahourt rouge'],
            ['$set' =>
                ['title' => 'Le petit fromage blanc']
            ],
        false);
        $this->assertInstanceOf('MongoDB\UpdateResult', $updateresult );
        $this->assertEquals(1, $updateresult->getMatchedCount());


        $updateresult  = $collection->update(['title' => '****'],
            ['$set' =>
                ['title' => '****']
            ],
            false);
        $this->assertInstanceOf('MongoDB\UpdateResult', $updateresult );
        $this->assertEquals(0, $updateresult->getMatchedCount());


        $updateresult  = $collection->update(['title' => 'Le petit berger blanc'],
            ['$set' =>
                ['title' => 'Le petit berger suisse']
            ],true);

        $this->assertInstanceOf('MongoDB\UpdateResult', $updateresult );
        $this->assertEquals(2, $updateresult->getMatchedCount());
    }



    public function testReplaceCollection()
    {
        $collection = DB::connection('mongodb')->getCollection('articles');

        $replaceresult  = $collection->replace(['title' => 'Le petit berger blanc'],
            [
                'title' => 'Le petit berger suisse',
                'note' => 16,
                'date' => new \DateTime('now'),
            ]);
        $this->assertInstanceOf('MongoDB\UpdateResult', $replaceresult );
        $this->assertEquals(1, $replaceresult->getMatchedCount());
    }




    public function testRemoveCollection()
    {
        $collection = DB::connection('mongodb')->getCollection('articles');

        $removeresult  = $collection->remove(['title' => 'Le petit yahourt rouge']);
        $this->assertInstanceOf('MongoDB\DeleteResult', $removeresult);
        $this->assertEquals(2, $collection->count());
    }


    public function testFindCollection()
    {
        $collection = DB::connection('mongodb')->getCollection('articles');

        $result = $collection->find(['title' => 'Le petit berger blanc'], [], false);
        $this->assertEquals('Le petit berger blanc', $result->title);

        $result = $collection->find(['title' => '***'],  [], false);
        $this->assertNull($result);


        $result = $collection->find(['title' => 'Le petit berger blanc']);

        $this->assertCount(2, $result->toArray());

        $result = $collection->find(['title' => '****']);
        $this->assertCount(0, $result->toArray());
    }



    public function testCollections()
    {
        $dbs = DB::connection('mongodb')->getCollections();
        $this->assertInstanceOf("MongoDB\Model\DatabaseInfoLegacyIterator",$dbs);
        $this->assertGreaterThanOrEqual(1,count($dbs));
    }

    public function testNamespace()
    {
        $namespace = DB::connection('mongodb')->getCollection('articles');
        $this->assertEquals('testing.articles', $namespace->getNamespace());
    }

    public function testGetQueryBuilder()
    {
//        $collection = DB::collection('articles');
//        $result = $collection->get(['title' => "Calvin and Hobbes"]);
//        $this->assertCount(2, $result);
//        exit(dump($result));

    }


    public function testWhereQueryBuilder(){
//        $collection = DB::collection('laravel.articles');
//        $result = $collection->where(['title' => "Calvin and Hobbes"]);
//        exit(dump($result));
    }



}