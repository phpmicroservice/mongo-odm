<?php

namespace test;

use MongoDB\BSON\ObjectId;
use MongoDB\UpdateResult;
use PHPUnit\Framework\TestCase;
use test\Collection\Demo;

/**
 * 集合的测试工具
 * Class CollectionTest
 * @package test
 */
class CollectionTest extends TestCase
{

    public function testOne()
    {
        $data = [
            'username' => uniqid() . 'username',
            'password' => password_hash('123456', 1)
        ];
        # 增加
        # 在集合中增加一条数据
        $coll = new Demo();
        # ->创建本地对象 -> 落库
        $id = $coll->createDocument()->create($data);
        $this->assertIsString($id, 'Id应该是字符串类型 [23]');# 字符串类型id
        # 查找
        $doc = $coll->findFirstById($id);
        $this->assertInstanceOf(\test\Document\Demo::class, $doc, '返回信息不是对象类型');# pa
        $this->assertArraySubset($data, $doc->dataGet(), false, '读取的数据错误');
        # 查找2 查出最后插入的一条 采用_id 进行排序,倒序排序
        $doc2 = $coll->findFirst([], [
            'sort' => [
                '_id' => -1
            ]
        ]);
        $this->assertInstanceOf(\test\Document\Demo::class, $doc2, '返回信息不是对象类型 [40]');#
        $this->assertArraySubset($data, $doc2->dataGet(), false, '读取的数据错误 [41]');
        # 修改
        $data2 = [
            'username' => time() . 'username'
        ];
        $upres = $coll->updateOne(['_id' => new ObjectId($id)], ['$set' => $data2]);
        $this->assertInstanceOf(UpdateResult::class, $upres, '返回信息不是修改对象');#

        if ($upres instanceof UpdateResult) {
            $modifiedCount = $upres->getModifiedCount();
            $this->assertEquals(1, $modifiedCount, '更新数量不正确');
        }
        if ($doc instanceof \test\Document\Demo) {

        }
        $doc->refresh();# 读取最新数据
        $this->assertArraySubset($data2, $doc->dataGet(), false, '读取的数据错误 [57]');
        # 删除
        $deres = $coll->deleteOne(['_id' => new ObjectId($id)]);
        $deletedCount = $deres->getDeletedCount();
        $this->assertEquals(1, $deletedCount, '删除数量不正确 [60]');
        # 统计
        $count = $coll->count();
        $this->assertIsInt($count, '统计结果不是数字 [64]');
        $coll->insertMany();
        dump($count);

    }

}