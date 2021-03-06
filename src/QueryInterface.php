<?php


namespace MongoOdm;


interface QueryInterface
{

    /**
     * 查询
     * @param array $parameters
     * @param array $option
     * @return \MongoDB\Driver\Cursor|Phalcon\Mvc\Model\ResultsetInterface
     */
    public function find(array $parameters = [], array $option);

    /**
     * 查询单条记录
     *
     * @param array parameters
     * @return static
     */
    public function findFirst($filter = [], $options = []);


    /**
     * 统计数量
     *
     * @param array parameters
     * @return int
     */
    public function count($parameters = null, $options = []);

    /**
     * 计算总和
     *
     * @param array parameters
     * @return double
     */
    public function sum($parameters = null);

    /**
     * 最大值
     *
     * @param array parameters
     * @return mixed
     */
    public function maximum($parameters = null);

    /**
     * 最小值
     *
     * @param array parameters
     * @return mixed
     */
    public function minimum($parameters = null);

    /**
     * 平均值
     *
     * @param array parameters
     * @return double
     */
    public function average($parameters = null, $option = null);


}