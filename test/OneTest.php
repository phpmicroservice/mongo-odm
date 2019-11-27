<?php

namespace test;

use MongoOdm\Collection;
use MongoOdm\Document;
use test\Collection\Demo;

class OneTest extends \PHPUnit\Framework\TestCase
{
    /**
     * 第一个测试
     * @throws \Exception
     */
    public function testOne()
    {
        $demo = new Demo();
        $this->assertInstanceOf(Collection::class, $demo, '错误的类型!');
        $demodoc = \test\Document\Demo::getDocment();
        $this->assertInstanceOf(Document::class, $demodoc, '错误的类型!');
    }


    /**
     * 第二个测试
     */
    public function testTwo()
    {
        $collection = new Demo();
        $databasename = $collection->getQuery()->getDatabaseName();
        $this->assertEquals($databasename, 'test');

    }

}