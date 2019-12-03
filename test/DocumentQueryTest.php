<?php

namespace test;

use PHPUnit\Framework\TestCase;
use test\Document\Demo;

/**
 * 查询构建器
 * Class DocumentTest
 * @package test
 */
class DocumentQueryTest extends TestCase
{
    /**
     * 先增加一些记录
     * @throws \Exception
     */
    public static function setUpBeforeClass()
    {
        $demo = new \test\Collection\Demo();
        for ($i = 1; $i < 1000; $i++) {
            $demo->createDocument()->create([
                'name' => uniqid() . time(),
                'type' => fmod($i, 10)
            ]);
        }

        $count = $demo->count();
        self::assertIsInt($count, '统计结果不是数字');
    }


    public function testLt()
    {
        $demo = new \test\Collection\Demo();;
        # lt
        $this->assertArraySubset([

            'type' => [
                '$lt' => 5
            ]

        ], $demo->lt('type', 5)->getFilter(),
            'lt 方法错误 [' . __LINE__ . ']');
        $list = $demo->lt('type', 5)->find();
        foreach ($list as $doc) {
            $this->assertLessThan(5, $doc->type, 'lt 方法错误 [' . __LINE__ . ']');
        }
        # lt or
        $this->assertArraySubset([
            '$or' => [
                [
                    'type' => [
                        '$lt' => 5
                    ]
                ]
            ]
        ],
            $demo->lt('type', 5, 1)->getFilter(),
            'lt 方法错误 [' . __LINE__ . ']');
        $list = $demo->lt('type', 5, 1)->find();
        foreach ($list as $doc) {
            $this->assertLessThanOrEqual(5, $doc->type, 'lt 方法错误 [' . __LINE__ . ']');
        }
    }


    public function testGt()
    {
        $demo = new \test\Collection\Demo();;
        # gt
        $this->assertArraySubset([

            'type' => [
                '$gt' => 5
            ]

        ], $demo->gt('type', 5)->getFilter(),
            'gt 方法错误 [' . __LINE__ . ']');
        $list = $demo->gt('type', 5)->find();
        foreach ($list as $doc) {
            $this->assertGreaterThan(5, $doc->type, 'gt 方法错误 [' . __LINE__ . ']');
        }
        # gt or
        $this->assertArraySubset([
            '$or' => [
                [
                    'type' => [
                        '$gt' => 5
                    ]
                ]
            ]
        ],
            $demo->gt('type', 5, 1)->getFilter(),
            'gt 方法错误 [' . __LINE__ . ']');
        $list = $demo->gt('type', 5, 1)->find();
        foreach ($list as $doc) {
            $this->assertGreaterThanOrEqual(5, $doc->type, 'gt 方法错误 [' . __LINE__ . ']');
        }
    }


    /**
     * 清理数据
     * @throws \Exception
     */
    public static function tearDownAfterClass()
    {
        $coll = new \test\Collection\Demo();
        # 删除全部内容
        $dere = $coll->deleteMany([]);
        self::assertEquals(999, $dere->getDeletedCount(), '删除了更多内容 [' . __LINE__ . ']');
    }


}