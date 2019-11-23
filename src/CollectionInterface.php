<?php

namespace MongoOdm;

/**
 * 集合
 * Interface CollectionInterface
 * @package mongoodm
 */
interface CollectionInterface
{


    /**
     * 返回映射的表名
     * @return string
     */
    public function getSource();

    /**
     *
     *
     * @return string
     */
    public function getSchema();


    /**
     * 查询
     *
     * @return Phalcon\Mvc\Model\ResultsetInterface
     */
    public static function find(array $parameters = null, array $option);

    /**
     * 查询单条记录
     *
     * @param array parameters
     * @return static
     */
    public static function findFirst($parameters = null);

    /**
     * 进行命令
     *
     * @param array $parameters
     * @return
     */
    public static function query(array $parameters = null);

    /**
     * 统计数量
     *
     * @param array parameters
     * @return int
     */
    public static function count($parameters = null);

    /**
     * 计算总和
     *
     * @param array parameters
     * @return double
     */
    public static function sum($parameters = null);

    /**
     * 最大值
     *
     * @param array parameters
     * @return mixed
     */
    public static function maximum($parameters = null);

    /**
     * 最小值
     *
     * @param array parameters
     * @return mixed
     */
    public static function minimum($parameters = null);

    /**
     * 平均值
     *
     * @param array parameters
     * @return double
     */
    public static function average($parameters = null);


}