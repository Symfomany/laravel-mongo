<?php

use Mongo\Mongodb\Model as Eloquent;
use Mongo\Mongodb\Eloquent\SoftDeletes;

class Soft extends Eloquent {
    use SoftDeletes;
    protected $collection = 'soft';
    protected static $unguarded = true;
    protected $dates = ['deleted_at'];
}