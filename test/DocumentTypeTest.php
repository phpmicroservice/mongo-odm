<?php

namespace test;

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\Type;
use PHPUnit\Framework\TestCase;
use test\Document\Demo;
use test\Document\DemoEvent;
use test\Document\DemoType;
use test\Type\A1;


/**
 * 文档自定义类型测试
 * Class DocumentTest
 * @package test
 */
class DocumentTypeTest extends TestCase
{

    /**
     *
     */
    public function testOne()
    {
        $doc = new DemoType();

        $time = time();
        $doc->dataSet([
            'a2' => $time,
            'a1' => $time
        ]);

        $doc2 = $doc->create();
        $this->assertInstanceOf(DemoType::class, $doc2, '不正确的插入');
        $this->assertEquals($time * 2, $doc2->a1->get2(), '不正确的结果');

    }

    public function tearDown()
    {
        $coll = new \test\Collection\Demo();
        # 删除全部内容
        $dere = $coll->deleteMany([]);
        $this->assertEquals(1, $dere->getDeletedCount(), '删除了更多内容 [' . __LINE__ . ']');
    }


}