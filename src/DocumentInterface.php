<?php

namespace MongoOdm;

use MongoDB\BSON\ObjectId;

/**
 * 文档
 * Interface DocumentInterface
 * @package mongoodm
 */
interface DocumentInterface
{

    /**
     * 获取
     * @param bool $string
     * @return string|ObjectId
     */
    public function getId($string = true);


    /**
     * @param Collection $collection
     * @return mixed
     */
    public function setCollection(Collection $collection);

    /**
     * @param array $data
     * @return string
     */
    public function create(array $data): string;

    /**
     * @param array $data
     * @return bool
     */
    public function save(array $data): bool;

    /**
     * 删除数据
     * @return bool
     */
    public function delete(): bool;

    /**
     * 刷新模型属性，从数据库中重新查询记录
     */
    public function refresh();


    /**
     * 重置模型实例数据
     */
    public function reset();


}