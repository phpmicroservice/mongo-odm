<?php

namespace test;

use PHPUnit\Framework\TestCase;
use test\Document\Demo;

/**
 * 文档基本测试curd
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
        $demo = new Demo();
        $demo = $demo->create($data);
        if ($demo instanceof Demo) {
            $id = $demo->getId();
        }
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
        $this->assertArraySubset($data2, $doc->dataGet(), false, '本地修改后数据错误 [' . __LINE__ . ']');
        # 刷新数据库数据
        $doc->refresh();
        $this->assertArraySubset($data, $doc->dataGet(), false, '本地数据拉取后数据错误  [' . __LINE__ . ']');
        # 本地数据重置
        $doc->reset();# 重置数据不落库
        $this->assertEmpty($doc->dataGet(), '文档重置后数据错误 [37]');
        # 落库修改
        $reSave = $doc->save($data2);
        $this->assertTrue($reSave, '落库修改失败 [30]');
        $this->assertArraySubset($data2, $doc->dataGet(), false, '落库修改后数据错误 [' . __LINE__ . ']');
        # 刷新数据
        $doc->refresh();
        $this->assertArraySubset($data2, $doc->dataGet(), false, '落库修改后数据错误2 [' . __LINE__ . ']');
        # 删除
        $doc->refresh();# 读取数据库数据
        $old = $col->count();# 统计集合
        $doc->delete();#删除数据对象
        $new = $col->count();# 统计集合
        $this->assertEquals($old - 1, $new, '文档删除错误 [36]');
        $this->assertEmpty($doc->dataGet(), '文档删除后重置失败 [37]');
    }

}