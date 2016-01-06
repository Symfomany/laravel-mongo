<?php

namespace Mongo\Mongodb;


/**
 * Class Collection
 */
class Collection extends \MongoDB\Collection{

    /**
     * Namespace of Collection
     * Connection with Manager
     *
     * @var Connection
     */
    protected $namespace;


    /**
     * The connection instance.
     * Connection with Manager
     *
     * @var Connection
     */
    protected $connection;


    /**
     * Constructor.
     */
    public function __construct(Connection $connection, $namespace)
    {
        $this->connection = $connection;
        $this->namespace = $this->connection->getNameDatabase().".".$namespace;

        parent::__construct($connection->getManager(), $this->namespace);
    }


    /**
     * Create an document or severel documents
     *
     */
    public function create($document, $options = []){

        if(count($document) !== count($document, COUNT_RECURSIVE)){
            return $this->insertMany($document, $options);
        }

        return $this->insertOne($document, $options);
    }

    /**
     * Create an document or severel documents
     *
     */
    public function insert($document, $options = []){

        return $this->insertOne($document, $options);
    }

    /**
     * Update an documents
     * $update: $inc, $mul, $rename, $setOnInsert, $set, $unset, $min, $max, ...
     * https://docs.mongodb.org/manual/reference/operator/update/
     */
    public function update($filter, $update, $multiple = true, array $options = []){

        if($multiple === true){
            return $this->updateMany($filter, $update, $options);
        }

        return $this->updateOne($filter, $update, $options);
    }


    /**
     * Find ONe or several documents
     */
    public function find($filter = [], array $options = [], $multiple = true){

        if($multiple === true){

            return parent::find($filter, $options);
        }else{

            return parent::findOne($filter,$options);
        }
    }

    /**
     * Replace a document
     * @param $filter
     * @param $replacement
     * @param array $options
     * @return \MongoDB\UpdateResult
     */
    public function remove($filter = "*", array $options = [], $multiple = false){

        if($filter == "*"){
            return parent::drop();
        }
        else if($multiple === true){
            return parent::deleteMany($filter, $options);
        }else{

            return parent::deleteOne($filter,$options);
        }
    }

    /**
     * Replace a document
     * @param $filter
     * @param $replacement
     * @param array $options
     * @return \MongoDB\UpdateResult
     */
    public function replace($filter, $replacement, array $options = []){

        return $this->replaceOne($filter,$replacement,$options);
    }

    /**
     * @return Connection
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param Connection $namespace
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }





}