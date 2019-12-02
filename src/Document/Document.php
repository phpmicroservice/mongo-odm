<?php


namespace MongoOdm\Document;

use MongoDB\BSON\ObjectId;
use MongoOdm\Collection;
use MongoOdm\Di;

/**
 * 文档
 * Class Document
 * @package MongoOdm
 * @property-read \MongoOdm\Collection $_collection
 */
class Document implements DocumentInterface, \ArrayAccess
{
    protected $_collection;# 集合对象 静态
    protected $_collection_class;# 集合类名
    protected $_data;# 数据
    # 默认值仅在保存的时候起作用
    protected $_fields;# 字段白名单
    protected $_field;# 字段[默认值,类型,是否可空,]
    protected $__default;# 是否在公开属性中使用默认值
    protected $_id;# 文档标识

    /**
     * 构造函数
     * Document constructor.
     * @param Collection $collection
     */
    public function __construct(Collection $collection = null)
    {
        if ($collection instanceof Collection) {
            $this->setCollection($collection);
        } else {
            $this->getCollection();
        }


        if (method_exists($this, 'initialize')) {
            $this->initialize();
        }
    }

    public function initialize()
    {

    }

    public function getCollection(): Collection
    {
        if ($this->_collection instanceof Collection) {
            return $this->_collection;
        }
        if ($this->_collection_class) {
            if (!class_exists($this->_collection_class)) {
                throw  new \Exception("未定义的集合");
            }
            $col = Di::getShared($this->_collection_class);
            if ($col instanceof Collection) {
                $this->setCollection($col);
            } else {
                throw  new \Exception("定义集合不是集合对象");
            }
        }
        return $this->_collection;
    }


    /**
     * bson序列化
     * @return array|object
     */
    function bsonSerialize()
    {
        return $this->toArray();
    }

    function bsonUnserialize(array $data)
    {
        $this->dataSet($data);
        $this->_id = $data['_id'];

    }

    /**
     * 获取Id 字符串| ObjectId 默认为字符串
     * @param bool $string
     * @return \MongoDB\BSON\ObjectId|string
     */
    public function getId($string = true)
    {
        if ($string) {
            return (string)$this->createId();
        }
        return $this->createId();
    }

    /**
     * 创建并返回Id,存在则直接返回
     */
    private function createId($id = null): ObjectId
    {

        if ($id instanceof ObjectId) {
            $this->_id = $id;
            $this->dataSet(['_id' => $this->_id]);
        }
        if (empty($this->_id)) {
            $this->_id = new ObjectId;
            $this->dataSet(['_id' => $this->_id]);
        }
        if (is_string($this->_id)) {
            $this->_id = new ObjectId($this->_id);
            $this->dataSet(['_id' => $this->_id]);
        }
        if ($this->_id instanceof ObjectId) {
            return $this->_id;
        }
        throw new \Exception('Id不是ObjectId对象');
    }

    /**
     * 创建文档,落库
     * @param array $data
     * @return Document
     */
    public function create(array $data = [])
    {
        if ($this->_id) {
            # 以存在的数据，不允许新建
            return false;
        }
        if ($data) {
            $this->dataSet($data);
        }
        if (!$this->_data) {
            # 没有数据
            throw new \Exception("没有数据存个毛线");
        }
        if (method_exists($this, 'beforeCreate')) {
            if ($this->beforeCreate($this->_data) === false) {
                return false;
            }
        }
        $insertOneResult = $this->getCollection()->insertOne($this);
        $this->createId($insertOneResult->getInsertedId());
        if (method_exists($this, 'afterCreate')) {
            $this->afterCreate($insertOneResult);
        }
        if (!$insertOneResult->getInsertedCount()) {
            return false;
        }
        return $this;
    }


    /**
     * 保存文档,落库
     * @param array $data
     * @return bool
     */
    public function save(array $data = []): bool
    {
        # 新建判断
        if (!$this->_id) {
            return $this->create($data);
        }
        if ($data) {
            $this->dataSet($data);
        }
        if (method_exists($this, 'beforeSave')) {
            if ($this->beforeSave($this->_data) === false) {
                return false;
            }
        }
        $uRes = $this->getCollection()->updateOne(['_id' => $this->getId(false)], [
            '$set' => $this->dataGet()
        ]);
        if (method_exists($this, 'afterSave')) {
            $this->afterSave($uRes);
        }
        return (bool)$uRes->getModifiedCount();
    }


    /**
     * 删除数据,落库
     * @return bool
     */
    public function delete(): bool
    {
        if (method_exists($this, 'beforeDelete')) {
            if ($this->beforeDelete($this->_data) === false) {
                return false;
            }
        }
        $dRes = $this->getCollection()->deleteOne(['_id' => $this->getId(false)]);

        if (!$dRes->getDeletedCount()) {
            return false;
        }
        $this->reset();
        $this->_id = null;# 重置标识Id
        if (method_exists($this, 'afterDelete')) {
            $this->afterDelete($dRes);
        }
        return true;
    }


    /**
     * 设置数据
     * @param array $data
     */
    public function dataSet(array $data)
    {
        foreach ($data as $key => $val) {
            $this->$key = $val;
        }
        return $this;
    }

    /**
     * 回去数据
     * @return mixed
     */
    public function dataGet(): array
    {
        return $this->_data;
    }


    /**
     * 刷新模型属性，从数据库中重新查询记录
     */
    public function refresh()
    {
        $doc2 = $this->getCollection()->getQuery()->findFirstById($this->getId());
        $this->dataSet($doc2->toArray());
        return $this;
    }


    /**
     * 重置模型实例数据,不落库,Id不变（Id为文档永久唯一标识）
     * @see 新的文档,创建新的文档对象
     */
    public function reset()
    {
        $this->_data = [];
        return $this;
    }

    /**
     * 设置关联链接
     * @param Collection $collection
     * @return Collection
     */
    public function setCollection(Collection $collection)
    {
        $this->_collection = $collection;
        $this->_collection_class = get_class($this);
        return $this;
    }

    /**
     * 是否存在键值对
     *
     */
    public function offsetExists($offset)
    {
        return isset($this->_data[$offset]);
    }

    /**
     * 获取键值,字段处理之后的
     */
    public function offsetGet($offset)
    {
        return $this->getCall($offset, $this->_data[$offset]);
    }

    /**
     * 设置键值对
     */
    public function offsetSet($offset, $value)
    {
        return $this->_data[$offset] = $this->fieldCall($offset, $value);
    }

    /**
     * 删除键值对
     */
    public function offsetUnset($offset)
    {
        unset($this->_data[$offset]);
    }

    /**
     * 设置数据
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        # 是否可设置
        if (!$this->_fields || in_array($name, $this->_fields)) {
            $this->setCall($name, $value);
        }
    }

    public function __get($name)
    {
        # 看字段是否存在
        if ($this->offsetExists($name)) {
            return $this->offsetGet($name);
        }
        if ($this->__default) {
            return $this->getDefault($name);
        }
        return;
    }


    /**
     * 获取字段默认值
     * @param $name
     */
    public function get4Default($name)
    {
        # 看字段是否存在
        if ($this->offsetExists($name)) {
            return $this->offsetGet($name);
        }
        return $this->getDefault($name);
    }


    /**
     * 获取字段默认值
     * @param $name
     */
    private function getDefault($name)
    {
        if (isset($this->_field[$name])) {
            # 存在字段定义
            $field = $this->_field[$name];
            if (isset($field[0])) {
                return $field[0];
            }
        }
        return;
    }

    /**
     * 字段处理
     * @param $name 字段名
     * @param $value 字段值
     */
    private function getCall($name, $value)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method($value, $name);
        }
        return $value;
    }

    /**
     *
     * @param $name
     * @param $value
     */
    private function setCall($name, $value)
    {
        $method = 'set' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method($value, $name);
        }
        if ($value) {
            return $this->_data[$name] = $value;
        }
        # 不存在设置器
        $field = $this->_field[$name] ?? [];
        if ($field) {
            if ($field[2] ?? false || is_null($value)) {
                return $this->_data[$name] = null;
            }
            $de = $field[0];
            return $this->_data[$name] = $de;
        }
        $this->_data[$name] = $value;
    }

    public function toArray(): array
    {
        return $this->dataGet();
    }


}