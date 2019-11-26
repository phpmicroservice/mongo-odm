<?php

namespace MongoOdm;

/**
 * Class Query
 * @package MongoOdm
 * @property \MongoDB\Collection $_collection
 */
class Query implements QueryInterface
{

    private $_collection;



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
     * @param $filter
     * @param $update
     * @param array $options
     * @return \MongoDB\UpdateResult
     */
    public function updateOne($filter, $update, array $options = [])
    {
        return $this->_collection->updateOne($filter, $update,  $options);
    }

    /**
     * 查询单条记录
     *
     * @param array parameters
     * @return static
     */
    public function findFirst($parameters = null)
    {

    }

    /**
     * 进行命令
     *
     * @param array $parameters
     * @return
     */
    public function query(array $parameters = null)
    {

    }

    /**
     * 统计数量
     *
     * @param array parameters
     * @return int
     */
    public function count($parameters = null)
    {

    }

    /**
     * 计算总和
     *
     * @param array parameters
     * @return double
     */
    public function sum($parameters = null)
    {

    }

    /**
     * 最大值
     *
     * @param array parameters
     * @return mixed
     */
    public function maximum($parameters = null)
    {

    }

    /**
     * 最小值
     *
     * @param array parameters
     * @return mixed
     */
    public function minimum($parameters = null)
    {

    }

    /**
     * 平均值
     *
     * @param array parameters
     * @return double
     */
    public function average($parameters = null)
    {
        return $this->_collection->aggregate($parameters, $option);
    }

}