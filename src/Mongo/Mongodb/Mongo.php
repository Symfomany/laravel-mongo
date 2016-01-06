<?php

namespace Mongo\Mongodb;
use Illuminate\Support\Facades\Facade;


/**
 * Class Connection
 */
class Mongo extends Facade
{

    protected static function getFacadeAccessor() { return 'Mongo\Mongodb\Connection'; }

}