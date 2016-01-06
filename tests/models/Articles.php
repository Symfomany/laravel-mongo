<?php

use Mongo\Mongodb\Model as Eloquent;


class Articles extends Eloquent {

    protected $collection = "articles";

//    public function users()
//    {
//        return $this->belongsToMany('Photo');
//    }

}