<?php

namespace test;

use PHPUnit\Framework\TestCase;
use test\Document\Demo;
use test\Document\DemoEvent;


/**
 * 文档事件测试
 * Class DocumentTest
 * @package test
 */
class DocumentEventTest extends TestCase
{

    /**
     * 测试新增
     * @return string
     */
    public function testCreate(): string
    {
        $data = [
            'name' => uniqid() . 'name'
        ];
        # 创建被阻止
        $demo = new DemoEvent();
        $re = $demo->create($data);
        $this->assertFalse($re);
        # 创建后不能阻止
        $demo2 = new DemoEvent();
        $re2 = $demo2->create([
            'name' => uniqid() . 'name',
            'date' => time()
        ]);
        $this->assertInstanceOf(DemoEvent::class, $re2, '返回对象不对 [' . __LINE__ . ']');
        $this->assertTrue($re2->isafterCreate, '没有执行对象的事件函数 [' . __LINE__ . ']');
        #
        if ($demo2 instanceof Demo) {

        }

        return $demo2->getId();
    }

    /**
     * @depends testCreate
     */
    public function testFind($id)
    {
        $doc = \test\Collection\Demo::findFirstById($id);
        $this->assertInstanceOf(DemoEvent::class, $doc, '返回对象不对 [' . __LINE__ . ']');
        return $doc;

    }


    /**
     * save 保存修改事件的测试
     */
    public function testSave()
    {
        # 验证失败 不能修改的
        $demo = new DemoEvent();
        $recreate = $demo->create([
            'name' => time() . uniqid(),
            'date' => time()
        ]);
        $this->assertInstanceOf(DemoEvent::class, $recreate, '创建失败 [' . __LINE__ . ']');
        $re = $demo->save(['name' => time() . uniqid()]);
        $this->assertFalse($re, '竟然保存成功了!');
        # 验证成功能够增加的
        $re2 = $demo->save([
            'name' => time() . uniqid(),
            'a' => time()
        ]);
        if ($re2 instanceof DemoEvent) {

        }
        $this->assertTrue($re2, '保存失败 [' . __LINE__ . ']');
        # 创建完成事件验证
        $this->assertTrue($demo->isafterSave, '保存完成事件没有执行');
        return $demo;

    }


    /**
     * 进行删除测
     * @depends testSave
     */
    public function testDelete(DemoEvent $doc)
    {
        $re = $doc->delete();
        $this->assertFalse($re, '竟然删除成功了 [' . __LINE__ . ']');
        $doc->cd = 1;
        $re2 = $doc->delete();
        $this->assertTrue($re2, '竟然删除失败了 [' . __LINE__ . ']');
    }


    public static function tearDownAfterClass()
    {
        $coll = new \test\Collection\Demo();
        # 删除全部内容
        $coll->deleteMany([]);

    }


}