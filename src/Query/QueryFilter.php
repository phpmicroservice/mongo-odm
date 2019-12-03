<?php

namespace MongoOdm\Query;

use MongoDB\Driver\Session;
use MongoOdm\Query;

trait QueryFilter
{


    /**
     * 字段是否存在 判断
     * @param $name
     * @param array $value
     * @param bool $or
     * @return $this
     */
    public function exists($name, array $value, $or = false)
    {
        if ($or) {
            return $this->setFilterOr('$exists', $name, $value);
        }
        return $this->setFilter('$exists', $name, $value);
    }

    /**
     * 设置过滤器/匹配器 or关系
     * @param $ex
     * @param $name
     * @param $value
     */
    private function setFilterOr($ex, $name, $value)
    {
        if (!isset($this->_filter['$or'])) {
            $this->_filter['$or'] = [];
        }
        if ($ex == '$equal') {
            $this->_filter['$or'][] = [$name => $value];
        } else {
            $this->_filter['$or'][] = [
                $name => [
                    $ex => $value
                ]
            ];
        }
        return $this;
    }

    /**
     * 设置过滤器/匹配器 and关系
     * @param $ex
     * @param $name
     * @param $value
     */
    private function setFilter($ex, $name, $value)
    {
        if (!isset($this->_filter['$or'])) {
            $this->_filter = [];
        }
        if ($ex == '$equal') {
            $this->_filter[$name] = $value;
        } else {
            $this->_filter[$name] = [
                $ex => $value
            ];
        }
        return $this;
    }

    /**
     * 不在范围 判断,会全表扫描
     * @param $name
     * @param array $value
     * @param bool $or
     * @return $this
     */
    public function nin($name, array $value, $or = false)
    {
        if ($or) {
            return $this->setFilterOr('$nin', $name, $value);
        }
        return $this->setFilter('$nin', $name, $value);
    }

    /**
     * 范围 判断
     * @param $name
     * @param array $value
     * @param bool $or
     * @return $this
     */
    public function in($name, array $value, $or = false)
    {
        if ($or) {
            return $this->setFilterOr('$in', $name, $value);
        }
        return $this->setFilter('$in', $name, $value);
    }

    /**
     * 不等于
     * @param $name
     * @param array $value
     * @param bool $or
     * @return $this
     */
    public function notequal($name, array $value, $or = false)
    {
        return $this->ne($name, $value, $or);
    }

    /**
     * 不等于 判断
     * @param $name
     * @param array $value
     * @param bool $or
     * @return $this
     */
    public function ne($name, array $value, $or = false)
    {
        if ($or) {
            return $this->setFilterOr('$ne', $name, $value);
        }
        return $this->setFilter('$ne', $name, $value);
    }

    /**
     * 小于等于 判断
     * @param $name
     * @param $value
     * @param bool $or
     * @return $this
     */
    public function lte($name, $value, $or = false)
    {
        if ($or) {
            return $this->setFilterOr('$lte', $name, $value);
        }
        return $this->setFilter('$lte', $name, $value);
    }

    /**
     * 小于判断
     * @param $name
     * @param $value
     * @param bool $or
     * @return $this
     */
    public function lt($name, $value, $or = false)
    {
        if ($or) {
            return $this->setFilterOr('$lt', $name, $value);
        }
        return $this->setFilter('$lt', $name, $value);
    }

    /**
     * 大于 判断
     * @param $name
     * @param $value
     * @param bool $or
     * @return $this
     */
    public function gt($name, $value, $or = false)
    {
        if ($or) {
            return $this->setFilterOr('$gt', $name, $value);
        }
        return $this->setFilter('$gt', $name, $value);
    }

    /**
     * 大于等于 判断
     * @param $name
     * @param $value
     * @param bool $or
     * @return $this
     */
    public function gte($name, $value, $or = false)
    {
        if ($or) {
            return $this->setFilterOr('$gte', $name, $value);
        }
        return $this->setFilter('$gte', $name, $value);
    }

    /**
     * 增加 等于判断 过滤器/匹配规则
     * @param $name
     * @param $value
     * @param bool $or
     * @return $this
     */
    public function equal($name, $value, $or = false)
    {
        if ($or) {
            return $this->setFilterOr('$equal', $name, $value);
        }
        return $this->setFilter('$equal', $name, $value);
    }

}