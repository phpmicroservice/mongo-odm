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
     */
    public function testA()
    {
        $demo = new \test\Collection\Demo();
        for ($i = 1; $i < 100; $i++) {

            $demo->createDocument()->create([
                'name' => uniqid() . time(),
                'type' => mt_rand(0, 10)
            ]);
        }

        $count = $demo->count();
        dump($count);
        $this->assertIsInt($count, '统计结果不是数字');
    }

    /**
     *
     * @depends testA
     */
    public function testOne()
    {
        $demo = new \test\Collection\Demo();
        $list = $demo->limit(5)->filter([
            'type' => mt_rand(0, 10)
        ])->find();
        foreach ($list as $doc) {
            dump($doc);
        }


    }


}