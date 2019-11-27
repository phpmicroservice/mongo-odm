<?php

namespace test;

use PHPUnit\Framework\TestCase;
use test\Document\Demo;

/**
 * 文档的测试
 * Class DocumentTest
 * @package test
 */
class DocumentTest extends TestCase
{
    public function testOne()
    {
        $data = [
            'name' => uniqid(),
            'date' => time()
        ];
        # 增加
        $demo = Demo::getDocment();
        $id = $demo->create($data);
        $this->assertIsString($id, 'Id应该是字符串类型 [23]');# 字符串类型id

        $col = new \test\Collection\Demo();
        $doc = $col->findFirstById($id);
        $this->assertInstanceOf(Demo::class, $doc, '返回doc对象错误 [27]');# 会返回doc对象
        if ($doc instanceof Demo) {
            $d28 = $doc->dataGet();
            # 验证数据正确性
            $this->assertArraySubset($data, $d28, false, 'data error [30]');
        }

        # 修改
        $data2 = [
            'name' => uniqid()
        ];
        $doc->dataSet($data2);
        $this->assertArraySubset($data2, $doc->dataGet(), false, '本地修改后数据错误 [30]');
        # 刷新数据库数据
        $doc->refresh();
        $this->assertArraySubset($data, $doc->dataGet(), false, '本地数据拉取后数据错误 [30]');
        # 本地数据重置
        $doc->reset();
        $this->assertEmpty($doc->dataGet(), '文档重置后数据错误 [37]');

        # 删除
        $doc->refresh();
        $old = $col->count();
        $doc->delete();#删除数据
        $new = $col->count();
        $this->assertEquals($old - 1, $new, '文档删除错误 [36]');
        $this->assertEmpty($doc->dataGet(), '文档删除后重置失败 [37]');
        $doc->refresh();
        dump($doc);

    }

}