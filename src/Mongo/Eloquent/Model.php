<?php

namespace Mongo\Eloquent;

use Mongo\Mongodb\Eloquent\HybridRelations;

/**
 * Class Model
 * @package Mongo\Eloquent
 */
abstract class Model extends \Illuminate\Database\Eloquent\Model {
    use HybridRelations;
}