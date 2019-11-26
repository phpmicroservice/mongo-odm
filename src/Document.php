<?php


namespace MongoOdm;

use MongoDB\Model\BSONDocument;

/**
 * 文档
 * Class Document
 * @package MongoOdm
 * @property-read BSONDocument $_bsondocument;
 * @property-read \MongoDB\Collection $_collection
 */
class Document implements DocumentInterface, \ArrayAccess
{
    private $_collection;# 集合对象 静态
    protected $_collection_class;# 集合类名
    private $_bsondocument;# BSON对象
    private $_data;# 数据
    # 默认值仅在保存的时候起作用
    protected $_fields;# 字段白名单
    protected $_field;# 字段[默认值,类型,是否可空,]
    protected $__default;# 是否在公开属性中使用默认值

    /**
     * 构造函数
     * Document constructor.
     * @param Collection $collection
     * @param null $bsondocument
     */
    public function __construct(Collection $collection, $bsondocument = null)
    {
        $this->setCollection($collection);
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
     * 设置bson对象
     * @param BSONDocument $bsondocument
     */
    public function setBsonDocument(BSONDocument $bsondocument)
    {
        $this->_bsondocument = $bsondocument;
        $this->_data = $bsondocument->getArrayCopy();
    }


    /**
     * 获取Id 字符串| ObjectId 默认为字符串
     * @param bool $string
     * @return \MongoDB\BSON\ObjectId|string|void
     */
    public function getId($string = true)
    {
        if ($string) {
            return (string)$this->_bsondocument->_id;
        }
        return $this->_bsondocument->_id;
    }

    /**
     * 创建文档,落库
     * @param array $data
     * @return string
     */
    public function create(array $data): string
    {

    }

    /**
     * 保存文档,落库
     * @param array $data
     * @return bool
     */
    public function save(array $data=[]): bool
    {
        # 新建判断
        if(!isset($this->_data['_id'])){
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
     * 删除数据,落库
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
     *
     * 重置模型实例数据,不落库
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
        return;

    }

}