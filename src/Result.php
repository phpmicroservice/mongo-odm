<?php

namespace MongoOdm;

use MongoDB\Driver\Cursor;

/**
 * 结果集处理,储存多个数据
 * Class Result
 * @package MongoOdm
 * @property Collection $_collection
 * @property Cursor $_cursor
 */
class Result implements ResultInterface, \Iterator, \SeekableIterator, \Countable
{
    protected $_cursor;
    protected $_collection;
    private $_count;# 统计
    private $_pointer = 0;# 游标
    private $_data;# 数据
    private $_document;# 文档对象

    /**
     * 构造函数,实例化
     * Result constructor.
     */
    public function __construct(Collection $collection, Cursor $cursor)
    {
        $this->_collection = $collection;
        $this->_cursor = $cursor;
        $this->_data = $cursor->toArray();
        $this->_count = count($this->_data);
        return $this;
    }

    /**
     * 返回当前元素
     *
     */
    public function current()
    {
        return $this->seek($this->_pointer);
    }

    /**
     * 前进到下一个元素
     */
    public function next()
    {
        $this->_pointer++;
        return $this->seek($this->_pointer);
    }

    /**
     * 返回当前元素的键
     */
    public function key()
    {
        return $this->_pointer;
    }

    /**
     * 检查当前位置是否有效
     *
     */
    public function valid($position = null)
    {
        if (is_null($position)) {
            return $this->_pointer < $this->_count;
        }
        return $position < $this->_count;
    }

    /**
     * 将Iterator倒退到第一个元素
     *
     */
    public function rewind()
    {
        $this->_pointer = 0;
        return $this->seek($this->_pointer);
    }


    /**
     * 获取结果集中的第一行,不会重置游标
     *
     * @return bool|\Phalcon\Mvc\ModelInterface
     */
    public function getFirst()
    {
        return $this->seek(0);
    }

    /**
     * 获取结果集中的最后一行,不会重置游标
     *
     * @return bool|\Phalcon\Mvc\ModelInterface
     */
    public function getLast()
    {
        return $this->seek($this->_count - 1);
    }


    /**
     * 寻找 位置
     * @param int $position
     */
    public function seek($position)
    {
        if (!$this->valid($position)) {
            return;
        }
        if (isset($this->_document[$position])) {
            return $this->_document[$position];
        }

        $this->_document[$position] = $this->_collection->createDocument($this->_data[$position]);
        return $this->_document[$position];
    }

    /**
     * Returns a complete resultset as an array, if the resultset has a big number of rows
     * it could consume more memory than currently it does.
     */
    public function toArray(): array
    {
        dd($this);

    }

    /**
     * 统计当前数据集个数
     */
    public function count()
    {
        return $this->_count;
    }


}