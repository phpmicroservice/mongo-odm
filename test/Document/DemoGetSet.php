<?php

namespace test\Document;

use MongoDB\DeleteResult;
use MongoDB\InsertOneResult;
use MongoDB\UpdateResult;
use MongoOdm\Document\Document;

/**
 * get set方法演示
 * Class DemoEvent
 * @package test\Document
 */
class DemoGetSet extends Document
{
    protected $_collection_class = \test\Collection\Demo::class;

    /**
     * 设置时间
     * @param $value
     * @param $name
     */
    public function setDate($value, $name)
    {
        return new \MongoDB\BSON\UTCDateTime($value);
    }

    public function getDate(\MongoDB\BSON\UTCDateTime $value, $name)
    {
        return $value->getTimestamp();
    }

}