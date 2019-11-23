<?php


namespace MongoOdm;

use MongoDB\Model\BSONDocument;

/**
 * 文档
 * Class Document
 * @package MongoOdm
 * @property-read BSONDocument $bson;
 */
class Document implements DocumentInterface, \ArrayAccess
{
    private static $collection;# 集合对象 静态
    private static $collection_class;# 集合类名
    private $bsondocument;# BSON对象

    public function __construct(Collection $collection, BSONDocument $bsondocument)
    {
        $this->setCollection($collection);
        $this->bsondocument = $bsondocument;
    }

    /**
     * 获取Id 字符串| ObjectId 默认为字符串
     * @param bool $string
     * @return \MongoDB\BSON\ObjectId|string|void
     */
    public function getId($string = true)
    {
        if($string){
            return (string)$this->bsondocument->_id;
        }
        return $this->bsondocument->_id;
    }

    /**
     * @param array $data
     * @return string
     */
    public function create(array $data): string
    {

    }

    /**
     * @param array $data
     * @return bool
     */
    public function save(array $data): bool
    {

    }

    /**
     * 删除数据
     * @return bool
     */
    public function delete(): bool
    {

    }

    /**
     * 刷新模型属性，从数据库中重新查询记录
     */
    public function refresh()
    {

    }


    /**
     * 重置模型实例数据
     */
    public function reset()
    {

    }

    /**
     * 设置关联链接
     * @param Collection $collection
     * @return Collection
     */
    public function setCollection(Collection $collection)
    {
        return $this->collection = $collection;
    }

    /**
     * Whether a offset exists
     * @link https://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return bool true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {

    }

    /**
     * Offset to retrieve
     * @link https://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {

    }

    /**
     * Offset to set
     * @link https://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {

    }

    /**
     * Offset to unset
     * @link https://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {

    }

}