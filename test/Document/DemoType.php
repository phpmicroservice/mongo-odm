<?php

namespace test\Document;


use MongoOdm\Document\Document;
use test\Type\A1;

/**
 * 事件演示,终止操演示
 * Class DemoEvent
 * @package test\Document
 * @property  \test\Type\A1 $a1
 */
class DemoType extends Document
{

    protected $_collection_class = \test\Collection\Demo::class;

    /**
     * 设置A1参数
     * @param $value
     * @return A1
     */
    protected function setA1($value, $name)
    {
        $a1 = new A1($value);
        $this->_data[$name] = $a1;

    }


}