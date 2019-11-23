<?php

namespace MongoOdm;

use function _\snakeCase;

/**
 * 集合,对应表,能够进行数据的增删改查
 * Interface Collection
 * @package mongoodm
 */
class Collection implements CollectionInterface
{

    protected $_source = '';# 集合名字
    protected $_collection;

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
     * Allows to query a set of records that match the specified conditions
     *
     * @return Phalcon\Mvc\Model\ResultsetInterface
     */
    public function find($parameters = null, array $option)
    {

    }

    /**
     * 模式方法
     * @param $name
     * @param $arguments
     */
    public static function __callStatic($name, $arguments)
    {
        $collection = Di::getShared(substr(strrchr(get_called_class(), '\\'), 1));
       $collection;
       dd($collection);
        // TODO: Implement __callStatic() method.
    }


    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param array parameters
     * @return static
     */
    public static function findFirst($parameters = null)
    {

    }

    /**
     * Create a criteria for a specific model
     *
     * @param \Phalcon\DiInterface dependencyInjector
     * @return \Phalcon\Mvc\Model\CriteriaInterface
     */
    public static function query($dependencyInjector = null)
    {

    }

    /**
     * Allows to count how many records match the specified conditions
     *
     * @param array parameters
     * @return int
     */
    public static function count($parameters = null)
    {

    }

    /**
     * Allows to calculate a sum on a column that match the specified conditions
     *
     * @param array parameters
     * @return double
     */
    public static function sum($parameters = null)
    {

    }

    /**
     * Allows to get the maximum value of a column that match the specified conditions
     *
     * @param array parameters
     * @return mixed
     */
    public static function maximum($parameters = null)
    {

    }

    /**
     * Allows to get the minimum value of a column that match the specified conditions
     *
     * @param array parameters
     * @return mixed
     */
    public static function minimum($parameters = null)
    {

    }

    /**
     * Allows to calculate the average value on a column matching the specified conditions
     *
     * @param array parameters
     * @return double
     */
    public static function average($parameters = null)
    {

    }


}