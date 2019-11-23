<?php

namespace MongoOdm;

/**
 * 结果集处理,储存多个数据
 * Class Resultset
 * @package MongoOdm
 */
class Resultset implements ResultsetInterface
{
    /**
     * 获取结果集中的第一行
     *
     * @return bool|\Phalcon\Mvc\ModelInterface
     */
    public function getFirst()
    {

    }

    /**
     * 获取结果集中的最后一行
     *
     * @return bool|\Phalcon\Mvc\ModelInterface
     */
    public function getLast()
    {

    }

    /**
     * Returns a complete resultset as an array, if the resultset has a big number of rows
     * it could consume more memory than currently it does.
     */
    public function toArray()
    {

    }


}