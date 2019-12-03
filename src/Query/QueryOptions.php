<?php

namespace MongoOdm\Query;


use MongoDB\Driver\Session;
use MongoOdm\Query;

trait QueryOptions
{

    /**
     * 进行limit设置
     * @param $limit
     * @return $this
     */
    public function limit(int $limit)
    {
        $this->_option['limit'] = $limit;
        return $this;
    }

    /**
     * as fields
     * @param $projection
     * @return $this
     */
    public function projection(array $projection)
    {
        return $this->fields($projection);
    }

    /**
     * 设置返回字段
     * @param $fields
     * @return $this
     * @see https://docs.mongodb.com/manual/tutorial/project-fields-from-query-results/
     */
    public function fields(array $fields)
    {
        return $this->setOption('projection', $fields);
    }

    /**
     * 设置执行选项
     * @param $name
     * @param $value
     * @return $this
     */
    private function setOption($name, $value)
    {
        $this->_option[$name] = $value;
        return $this;
    }

    /**
     * 要跳过的文档数
     * @param $skip
     * @return $this
     */
    public function skip(int $skip)
    {
        $this->_option['skip'] = $skip;
        return $this;
    }

    /**
     * 第一批要返回的文档数量
     * @param $batchSize
     * @return $this
     * @see https://docs.mongodb.com/php-library/master/reference/method/MongoDBCollection-find/#phpmethod.MongoDB\Collection::find
     */
    public function batchSize(int $batchSize)
    {
        $this->_option['batchSize'] = $batchSize;
        return $this;
    }

    /**
     * 查询注释
     * @param $comment
     * @return $this
     */
    public function comment(string $comment)
    {
        $this->_option['comment'] = $comment;
        return $this;
    }

    /**
     *  cursorType 游标类型
     * @param $cursorType
     * @return $this
     */
    public function cursorType(int $cursorType)
    {
        $this->_option['cursorType'] = $cursorType;
        return $this;
    }

    /**
     * 强制使用索引
     * @param $hint
     * @return $this
     */
    public function hint($hint)
    {
        $this->_option['hint'] = $hint;
        return $this;
    }

    /**
     * 超时时间
     * @param $maxAwaitTimeMS
     * @return $this
     */
    public function maxAwaitTimeMS(int $maxAwaitTimeMS)
    {
        return $this->setOption('maxAwaitTimeMS', $maxAwaitTimeMS);
    }

    /**
     * 光标操作超时事件
     * @param $maxTimeMS
     * @return $this
     */
    public function maxTimeMS(int $maxTimeMS)
    {
        return $this->setOption('maxTimeMS', $maxTimeMS);
    }


    /**
     * 排序
     * @param array $sort
     * @return $this
     */
    public function sort(array $sort)
    {
        $this->_option['sort'] = $sort;
        return $this;
    }

    /**
     * 客户端关联
     * @param Session $session
     * @return $this
     */
    public function session(Session $session)
    {
        return $this->setOption('session', $session);
    }

    /**
     * max option 设置
     * @param $max
     * @return $this
     */
    public function maxOption($max)
    {
        return $this->setOption('max', $max);
    }

    /**
     * min option 设置
     * @param $min
     * @return $this
     */
    public function minOption($min)
    {
        return $this->setOption('min', $min);
    }

    /**
     * 在副本及内部使用 oplogReplay
     * @param bool $value
     * @return $this
     */
    public function oplogReplay(bool $value)
    {
        return $this->setOption('oplogReplay', $value);
    }

    /**
     * 防止游标空闲10分钟超时
     * @param $noCursorTimeout
     * @return $this
     */
    public function noCursorTimeout(bool $noCursorTimeout)
    {
        return $this->setOption('noCursorTimeout', $noCursorTimeout);
    }


    /**
     * 如果为true，则只返回结果文档中的索引键。
     * @param $value
     * @return mixed
     */
    public function returnKey(bool $value)
    {
        return $this->setOption('returnKey', $value);
    }

    /**
     * 是否返回每个文档的记录标识符 $recordId
     * @param $value
     * @return mixed
     */
    public function showRecordId(bool $value)
    {
        return $this->setOption('showRecordId', $value);
    }

    /**
     * 防止光标由于中间的写入操作而多次返回文档。
     * @param $value
     * @return mixed
     */
    public function snapshot(bool $value)
    {
        return $this->setOption('snapshot', $value);
    }

    /**
     * 对于针对碎片集合的查询，如果某些碎片不可用，则返回mongos的部分结果，而不是抛出错误。
     * @param $value
     * @return mixed
     */
    public function allowPartialResults($value)
    {
        return $this->setOption('allowPartialResults', $value);
    }


    /**
     * @param array $value
     * @return mixed
     */
    public function typeMap(array $value)
    {
        return $this->setOption('typeMap', $value);
    }


    /**
     *
     * @param $value
     * @return mixed
     */
    public function modifiers($value)
    {
        return $this->setOption('modifiers', $value);
    }


}