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




}