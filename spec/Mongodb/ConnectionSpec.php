<?php

namespace spec\Mongo\Mongodb;

use Illuminate\Support\Facades\Config;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConnectionSpec extends ObjectBehavior
{
    /**
     * @var
     */
    protected $config;

    /**
     * Initialize
     */
    function let(){
        $this->config = array(
                'driver'   => 'mongodb',
                'host'     => env('DB_HOST', 'localhost'),
                'port'     => env('DB_MONGODB_PORT', 27017),
                'database' => env('DB_MONGODB_DATABASE', 'laravel'),
                'username' => env('DB_MONGODB_USERNAME', ''),
                'password' => env('DB_MONGODB_PASSWORD', ''),
                'options' => array(
                        'db' => 'laravel' // sets the authentication database required by mongo 3
                )
        );

        $this->beConstructedWith($this->config);

    }

    /**
     * Instiantiable
     */
    function it_is_initializable()
    {
        $this->shouldHaveType('Mongo\Mongodb\Connection');

    }

    /**
     * getDsn
     */
    function it_getDsn(){
        $this->getDsn($this->config)->shouldReturn("mongodb://localhost:27017/laravel");
    }

    /**
     * getDsn
     */
    function it_createManager(){

        $this->createManager("mongodb://localhost:27017/laravel", $this->config, [])->shouldReturnAnInstanceOf("MongoDB\Driver\Manager");
    }

    /**
     * getDsn
     */
    function it_collection(){

        $this->collection("Book")->shouldReturnAnInstanceOf("Mongo\Mongodb\Query\Builder");
    }

    /**
     * getDsn
     */
    function it_table(){

        $this->table("Book")->shouldReturnAnInstanceOf("Mongo\Mongodb\Query\Builder");
    }

    /**
     * getDsn
     */
    function it_get_collection(){

        $this->getCollection("Book")->shouldReturnAnInstanceOf("Mongo\Mongodb\Collection");
    }

    /**
     * getDsn
     */
    function it_get_database(){

        $this->getDatabase("laravel")->shouldReturnAnInstanceOf("Mongo\Mongodb\Database");
    }

    /**
     * getDsn
     */
    function it_getDefaultPostProcessor(){

        $this->getDefaultPostProcessor()->shouldReturnAnInstanceOf("Mongo\Mongodb\Query\Processor");
    }


    /**
     * getDsn
     */
//    function it_collection(){
//
////        $this->collection("Movies")->shouldReturnAnInstanceOf("Illuminate\Database\Query\Builder");
//    }


}
