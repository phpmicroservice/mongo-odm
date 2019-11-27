<?php

namespace test;

use PHPUnit\Framework\TestCase;

/**
 * 集合的测试工具
 * Class CollectionTest
 * @package test
 */
class CollectionTest extends TestCase
{

    public function testOne()
    {
        $this->assertArraySubset(['a', 'b', 'c'], ['a', 'b', 'c'], false, 'ArraySubset 1');
    }

}