<?php

namespace test;

use PHPUnit\Framework\TestCase;
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

        $person = $col->find([
        ], [
            'sort' => [
                '_id' => -1
            ],
            'limit' => 5
        ]);
        $this->assertTrue(true);


    }

}