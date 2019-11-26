<?php

namespace MongoOdm;

use MongoDB\Driver\Cursor;
use function _\snakeCase;
use function _\startsWith;

/**
 * 集合,对应表,能够进行数据的增删改查
 * Interface Collection
 * @package mongoodm
 */
class Collection implements CollectionInterface
{

    protected $_source = '';# 集合名字
    protected $_collection; # 集合链接对象
    protected $_documentclass; # 文档对象类

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
     * 从返回新模型的数组中为模型分配值
     *
     * @param \Phalcon\Mvc\Model base
     * @param array data
     * @param array columnMap
     * @param int dirtyState
     * @param boolean keepSnapshots
     * @return \Phalcon\Mvc\Model result
     */
    public static function cloneResultMap(array $data, $columnMap, int $dirtyState = 0, boolean $keepSnapshots = null)
    {

    }

    /**
     * Assigns values to a model from an array returning a new model
     *
     * @param \Phalcon\Mvc\ModelInterface base
     * @param array data
     * @param int dirtyState
     * @return \Phalcon\Mvc\ModelInterface
     */
    public static function cloneResult(array $data, int $dirtyState = 0)
    {

    }

    /**
     * Returns an hydrated result based on the data and the column map
     *
     * @param array data
     * @param array columnMap
     * @param int hydrationMode
     */
    public static function cloneResultMapHydrate(array $data, $columnMap, int $hydrationMode)
    {

    }

    /**
     * 模式方法
     * @param $name
     * @param $arguments
     */
    public static function __callStatic($name, $arguments)
    {
        $re = self::_invokeFinder($name, $arguments);
        if (is_null($re)) {
            throw new \Exception('err114');
        }
        return $re;
    }

    /**
     * 尝试检查查询是否必须调用查找程序
     * @param string $method
     * @param array $arguments
     */
    protected final static function _invokeFinder(string $method, array $arguments)
    {
        $collection = Di::getShared(get_called_class());

        if (method_exists(Query::class, $method)) {
            $re = call_user_func_array([(new Query($collection->_collection)), $method], $arguments);
            return $collection->data2res($re);
        }
        return null;
    }

    /**
     * 创建一个 文档对象
     * @param null $bsondocument
     * @return DocumentInterface
     * @throws \Exception
     */
    public function createDocument($bsondocument = null): DocumentInterface
    {
        if (!class_exists($this->_documentclass)) {
            # 文档类不存在
            throw new \Exception("不存在的文档类!");
        }
        return new $this->_documentclass($this,$bsondocument);
    }

    /**
     * 将mongodb返回的数据转换为 result
     */
    private function data2res($data)
    {

        if ($data instanceof Cursor) {
            $res = new Result($this,$data);
            return $res;
            # 多条数据
        }
        # 一条数据

    }


}