<?php

namespace MongoOdm;

use MongoDB\BSON\ObjectId;
use MongoDB\Driver\Cursor;
use MongoDB\Driver\Session;
use MongoOdm\Query\QueryFilter;
use MongoOdm\Query\QueryOptions;

/**
 * Class Query
 * @package MongoOdm
 * @property \MongoDB\Collection $_collection
 * @mixin \MongoDB\Collection
 */
class Query implements QueryInterface
{

    private $_collection;
    private $_filter = [];
    private $_option = [];

    use QueryOptions;
    use QueryFilter;

    public function __construct(\MongoDB\Collection $collection)
    {
        $this->_collection = $collection;
    }


    /**
     * 查询
     * @param array $filter
     * @param array $option
     * @return Cursor
     */
    public function find(array $filter = [], array $options = [])
    {
        return $this->filterOptionsCall('find', $filter, $options);
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
        $filter = $this->getFilter($filter, true);
        $options = $this->getOptions($options, true);
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
        return $this->filterOptionsCall('deleteOne', $filter, $options);
    }

    /**
     * 删除多个
     * @param $filter
     * @param array $options
     * @return \MongoDB\DeleteResult
     */
    public function deleteMany($filter, array $options = [])
    {
        return $this->filterOptionsCall('deleteMany', $filter, $options);
    }

    /**
     * 查询单条记录
     *
     * @param array parameters
     * @return static
     */
    public function findFirst($filter = [], $options = [])
    {
        return $this->filterOptionsCall('findOne', $filter, $options);
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
        return $this->filterOptionsCall('findOne', $filter, $options);


    }


    /**
     * 统计数量
     *
     * @param array $filter
     * @return int
     */
    public function count($filter = [], $options = [])
    {
        return $this->filterOptionsCall('countDocuments', $filter, $options);
    }

    /**
     * 对参数是  $filter,$options 的方法进行调用
     * @param $name
     * @param array $filter
     * @param array $options
     * @return mixed
     */
    private function filterOptionsCall($name, $filter = [], array $options = [])
    {
        $filter = $this->getFilter($filter, true);
        $options = $this->getOptions($options, true);
        return $this->_collection->$name($filter, $options);
    }


    /**
     * 回去过滤规则
     * @param array $filter
     * @param bool $reset
     * @return array
     */
    public function getFilter($filter = [], $reset = false)
    {
        $filter = array_merge_recursive($this->_filter, $filter);
        if ($reset) {
            $this->_filter = [];
        }
        return $filter;
    }


    /**
     * 获取设置
     * @param array $options
     */
    public function getOptions($options = [], $reset = false)
    {
        $options = array_merge_recursive($this->_option, $options);
        if ($reset) {
            $this->_option = [];
        }
        return $options;
    }


    /**
     * 增加过滤器条件
     * @param array $filter
     * @return $this
     */
    public function filter(array $filter)
    {
        $this->_filter = array_merge_recursive($this->_filter, $filter);
        return $this;
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