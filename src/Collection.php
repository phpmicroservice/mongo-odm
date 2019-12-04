<?php

namespace MongoOdm;

use MongoDB\Driver\Cursor;
use MongoDB\Model\BSONDocument;
use MongoOdm\Document\Document;
use MongoOdm\Document\Native;
use MongoOdm\Document\NativeInterface;
use function _\snakeCase;
use function _\startsWith;

/**
 * 集合,对应表,能够进行数据的增删改查
 * Interface Collection
 * @package mongoodm
 * @property \MongoDB\Collection $_collection
 * @mixin Query
 */
class Collection implements CollectionInterface
{

    protected $_source = '';# 集合名字
    protected $_collection; # 集合链接对象
    protected $_documentclass; # 文档对象类
    protected $_field = [];

    /**
     * 对象初始化,运行 initialize,并设置默认集合对象
     * Collection constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        if (method_exists($this, 'initialize')) {
            $this->initialize();
        }
        $this->_collection = Di::getInstance()->getCollection($this->getSource());
    }


    /**
     *
     */
    public function initialize()
    {

    }

    /**
     * 返回映射的表名
     *
     * @return string
     */
    public function getSource()
    {
        if ($this->_source) {
            return $this->_source;
        }
        return snakeCase(substr(strrchr(get_class($this), '\\'), 1));
    }

    /**
     * 返回映射表所在的模式名称
     *
     * @return string
     */
    public function getSchema()
    {

    }

    /**
     * 魔术方法 调用不存在的方法的时候调用
     * @param $method
     * @param $arguments
     * @return Result|null
     */
    public function __call($method, $arguments)
    {
        if (method_exists(Query::class, $method)) {
            return call_user_func_array([$this->getQuery(), $method], $arguments);
        }
        throw new \Exception("不存在的方法:" . $method);
    }

    /**
     * 获取集合连接对象
     * @return \MongoDB\Collection
     */
    public function getQuery(): Query
    {
        return new Query($this->_collection);
    }

    /**
     * 魔术方法,调用不存在的静态方法的时候调用
     * @param $name
     * @param $arguments
     * @return Result|null
     * @throws \Exception
     */
    public static function __callStatic($name, $arguments)
    {
        return self::_invokeFinder($name, $arguments);
    }

    /**
     * 尝试检查查询是否必须调用查找程序
     * @param string $method
     * @param array $arguments
     */
    protected final static function _invokeFinder(string $method, array $arguments)
    {
        $collection = Di::getShared(get_called_class());
        if (method_exists(Query::class, $method) && $collection instanceof Collection) {
            return call_user_func_array([$collection->getQuery(), $method], $arguments);
        }
        throw new \Exception("没有找到静态方法:" . $method);
    }

    /**
     * 创建一个 文档对象
     * @param null $bsondocument
     * @return DocumentInterface |NativeInterface
     * @throws \Exception
     */
    public function createDocument()
    {
        if (!class_exists($this->_documentclass)) {
            # 文档类不存在
            throw new \Exception("不存在的文档类!");
        }
        return new $this->_documentclass($this);
    }


}