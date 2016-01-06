<?php

namespace Mongo\Mongodb;

/**
 * Class Database
 * Override Connection
 */
class Database extends \MongoDB\Database{


    /**
     * @return $this
     */
    public function getName(){
        return $this->getDatabaseName();
    }

}