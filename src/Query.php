<?php

namespace MongoOdm;

use MongoDB\BSON\ObjectId;
use MongoDB\Driver\Cursor;

/**
 * Class Query
 * @package MongoOdm
 * @property \MongoDB\Collection $_collection
 * @mixin \MongoDB\Collection
 */
class Query implements QueryInterface
{

    private $_collection;
    private $_parameters = [];
    private $_option = [];


    public function __construct(\MongoDB\Collection $collection)
    {
        $this->_collection = $collection;
    }


    /**
     * 查询
     * @param array $parameters
     * @param array $option
     * @return Result
     */
    public function find(array $parameters = [], array $option)
    {
        return $this->_collection->find($parameters, $option);
    }

    /**
     * 插入一条
     * @param $document
     * @param array $options
     * @return \MongoDB\InsertOneResult
     */
    public function insertOne($document, array $options = [])
    {
        return $this->_collection->insertOne($document, $options);
    }

    /**
     * 更新一条
     * @param $filter
     * @param $update
     * @param array $options
     * @return \MongoDB\UpdateResult
     */
    public function updateOne($filter, $update, array $options = [])
    {
        return $this->_collection->updateOne($filter, $update, $options);
    }

    /**
     * 删除一个
     * @param $filter
     * @param array $options
     * @return \MongoDB\DeleteResult
     */
    public function deleteOne($filter, array $options = [])
    {
        return $this->_collection->deleteOne($filter, $options);
    }

    /**
     * 查询单条记录
     *
     * @param array parameters
     * @return static
     */
    public function findFirst($filter = [], $options = [])
    {
        return $this->_collection->findOne($filter, $options);
    }

    /**
     * 根据id获取第一个
     * @param $id
     * @param $options
     * @return array|object|null
     */
    public function findFirstById($id, $options = [])
    {
        $filter = [
            '_id' => new ObjectId($id)
        ];
        return $this->_collection->findOne($filter, $options);
    }


    /**
     * 统计数量
     *
     * @param array parameters
     * @return int
     */
    public function count($match = null, $options = [])
    {
        $parameters = $this->_parameters;
        if ($match) {
            $parameters[0]['$match'] = $match;
        }
        $this->_parameters = [];
        return $this->_collection->countDocuments($parameters, $options);
    }

    /**
     * 计算总和
     *
     * @param array parameters
     * @return double
     */
    public function sum($parameters = null)
    {
        return $this->_collection->aggregate($parameters, $option);
    }

    /**
     * 最大值
     *
     * @param array parameters
     * @return mixed
     */
    public function maximum($parameters = null)
    {
        return $this->_collection->aggregate($parameters, $option);
    }

    /**
     * 最小值
     *
     * @param array parameters
     * @return mixed
     */
    public function minimum($parameters = null)
    {
        return $this->_collection->aggregate($parameters, $option);
    }

    /**
     * 平均值
     *
     * @param array parameters
     * @return double
     */
    public function average($parameters = null, $option = null)
    {
        return $this->_collection->aggregate($parameters, $option);
    }


    /**
     * 进行limit设置
     * @param $limit
     * @return $this
     */
    public function limit($limit)
    {
        $this->_option['limit'] = $limit;
        return $this;
    }

    /**
     * 删除多个
     * @param $filter
     * @param array $options
     * @return \MongoDB\DeleteResult
     */
    public function deleteMany($filter, array $options = [])
    {
        $options = $this->getOptions($options, true);
        return $this->_collection->deleteMany($filter, $options);
    }


    /**
     * 获取设置
     * @param array $options
     */
    private function getOptions($options = [], $reset = false)
    {
        $options = array_merge_recursive($this->_option, $options);
        if ($reset) {
            $this->_option = [];
        }
        return $options;
    }


    /**
     * 魔术方法,当调用不存在的方法的时候调用
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this->_collection, $name)) {
            return call_user_func_array([$this->_collection, $name], $arguments);
        }
    }

}