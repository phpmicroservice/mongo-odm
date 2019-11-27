<?php

namespace test;

use MongoOdm\Collection;
use test\Collection\Demo;

class OneTest extends \PHPUnit\Framework\TestCase
{
    public function testOne()
    {
        $demo = new Demo();
        $this->assertInstanceOf(Collection::class, $demo, '错误的类型!');

    }

}