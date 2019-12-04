<?php

namespace test;

use PHPUnit\Framework\TestCase;
use test\Collection\Demo1;
use test\Document\Demo;

/**
 * 测试的测试
 * @package test
 */
class DTest extends TestCase
{
    public function testOne()
    {
        $a1 = ['a', 'b', 'c', 'd'];
        $this->assertArraySubset(['a', 'b', 'c'], $a1, false, 'ArraySubset 1');
//        $this->assertArraySubset(['b', 'c'], $a1,false,'ArraySubset 2');
//        $this->assertArraySubset(['a', 'c', 'b'], $a1,false,'ArraySubset 3');
    }

    public function testTwo()
    {
        $col = new \test\Collection\Demo();
        $result = $col->getQuery()->insertOne(new \test\Persistable\Demo(uniqid() . 'person'));
        $this->assertEquals(1, $col->count(), '内容有点多 [' . __LINE__ . ']');
        $person = $col->find();
        $this->assertTrue(true);
    }

    public function testSan()
    {
        $demo1 = new Demo1();
        $doc = $demo1->createDocument()->create([
            'demo' => 1,
            'name' => uniqid()
        ]);

    }


    public function tearDown()
    {
        $coll = new \test\Collection\Demo();
        # 删除全部内容
        $coll->deleteMany([]);
    }

}