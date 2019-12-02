<?php

namespace test\Document;

use MongoDB\DeleteResult;
use MongoDB\InsertOneResult;
use MongoDB\UpdateResult;
use MongoOdm\Document\Document;

/**
 * 事件演示,终止操演示
 * Class DemoEvent
 * @package test\Document
 */
class DemoEvent extends Document
{
    public $isafterSave;
    public $isafterCreate;
    public $isAfterDelete;
    protected $_collection_class = \test\Collection\Demo::class;

    /**
     * 创建之前的操作 ,可以终止操作
     */
    public function beforeCreate(array $data)
    {
        if (!isset($data['date'])) {
            return false;
        }
    }

    /**
     * 创建之后
     * @param InsertOneResult $insertOneResult
     * @return bool
     */
    public function afterCreate(InsertOneResult $insertOneResult)
    {
        $this->isafterCreate = true;
        return false;
    }


    /**
     * 修改 之前的操作
     */
    public function beforeSave($data)
    {
        if (!isset($data['a'])) {
            # a 不存在则不允许增加,模拟验证
            return false;
        }
    }


    /**
     * 修改之后
     * @param UpdateResult $updateResult
     * @return bool
     */
    public function afterSave(UpdateResult $updateResult)
    {
        $this->isafterSave = true;
        return false;
    }

    /**
     * 删除事件 删除之前
     * @param array $data
     */
    public function beforeDelete(array $data)
    {
        if (!($data['cd'] ?? 0)) {
            return false;
        }
    }

    /**
     * 删除事件 删除后
     * @param DeleteResult $deleteResult
     */
    public function afterDelete(DeleteResult $deleteResult)
    {
        $this->isAfterDelete = true;
        return false;

    }

}