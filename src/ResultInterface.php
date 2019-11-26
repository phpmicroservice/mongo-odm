<?php

namespace MongoOdm;

/**
 * 数据资源
 * Interface ResultsetInterface
 * @package MongoOdm
 */
interface ResultInterface
{
    /**
     * 获取结果集中的第一行
     *
     * @return bool|\Phalcon\Mvc\ModelInterface
     */
    public function getFirst();

    /**
     * 获取结果集中的最后一行
     *
     * @return bool|\Phalcon\Mvc\ModelInterface
     */
    public function getLast();

    /**
     * Returns a complete resultset as an array, if the resultset has a big number of rows
     * it could consume more memory than currently it does.
     */
    public function toArray(): array;
}