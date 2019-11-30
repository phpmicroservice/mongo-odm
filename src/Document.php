<?php


namespace MongoOdm;

use MongoDB\Model\BSONDocument;

/**
 * 文档
 * Class Document
 * @package MongoOdm
 * @property-read BSONDocument $_bsondocument;
 * @property-read \MongoOdm\Collection $_collection
 */
class Document implements DocumentInterface, \ArrayAccess
{
    private $_collection;# 集合对象 静态
    protected static $_collection_class;# 集合类名
    private $_bsondocument;# BSON对象
    private $_data;# 数据
    # 默认值仅在保存的时候起作用
    protected $_fields;# 字段白名单
    protected $_field;# 字段[默认值,类型,是否可空,]
    protected $__default;# 是否在公开属性中使用默认值
    protected $_id;# 文档标识

    /**
     * 构造函数
     * Document constructor.
     * @param Collection $collection
     * @param null $bsondocument
     */
    public function __construct(Collection $collection = null, $bsondocument = null)
    {
        if ($collection instanceof Collection) {
            $this->setCollection($collection);
        }

        if ($bsondocument) {
            $this->setBsonDocument($bsondocument);
        }
        if (method_exists($this, 'initialize')) {
            $this->initialize();
        }
    }

    public function initialize()
    {

    }

    /**
     * 获取这个对象
     * @return bool|Document|void
     */
    public static function getDocment()
    {
        if (!class_exists(get_called_class()::$_collection_class)) {
            return false;
        }
        $col = Di::getShared(get_called_class()::$_collection_class);
        if ($col instanceof Collection) {
            return new self($col);
        }
        return;
    }


    /**
     * 设置bson对象
     * @param BSONDocument $bsondocument
     */
    public function setBsonDocument(BSONDocument $bsondocument)
    {
        $this->_bsondocument = $bsondocument;

        $this->_data = $bsondocument->getArrayCopy();
        $this->_id = $this->_data['_id'];
    }


    /**
     * 获取Id 字符串| ObjectId 默认为字符串
     * @param bool $string
     * @return \MongoDB\BSON\ObjectId|string|void
     */
    public function getId($string = true)
    {
        if ($string) {
            return (string)$this->_id;
        }
        return $this->_id;
    }

    /**
     * 创建文档,落库
     * @param array $data
     * @return string
     */
    public function create(array $data): string
    {
        if (isset($this->_id)) {
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
        $insertOneResult = $this->_collection->insertOne($this->_data);
        return $insertOneResult->getInsertedId();
    }


    /**
     * 保存文档,落库
     * @param array $data
     * @return bool
     */
    public function save(array $data = []): bool
    {
        # 新建判断
        if (!$this->getId()) {
            return $this->create($data);
        }
        if ($data) {
            $this->dataSet($data);
        }
        $uRes = $this->_collection->updateOne(['_id' => $this->getId(false)], [
            '$set' => $this->_data
        ]);
        return (bool)$uRes->getModifiedCount();
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
     * 删除数据,落库
     * @return bool
     */
    public function delete(): bool
    {
        $uRes = $this->_collection->deleteOne(['_id' => $this->getId(false)]);
        $this->reset();
        return (bool)$uRes->getDeletedCount();
    }

    /**
     * 刷新模型属性，从数据库中重新查询记录
     */
    public function refresh()
    {
        $dd = $this->_collection->getQuery()->findFirstById($this->getId());
        if ($dd instanceof BSONDocument) {
            $this->setBsonDocument($dd);
        }
    }


    /**
     * 重置模型实例数据,不落库,Id不变（Id为文档永久唯一标识）
     * @see 新的文档,创建新的文档对象
     */
    public function reset()
    {
        $this->_data = [];
        $this->_bsondocument = null;
    }

    /**
     * 设置关联链接
     * @param Collection $collection
     * @return Collection
     */
    public function setCollection(Collection $collection)
    {
        return $this->_collection = $collection;
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
            return $this->setCall($name, $value);
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

}