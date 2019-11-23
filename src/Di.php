<?php

namespace MongoOdm;

use MongoDB\Client;
use MongoDB\Database;

/**
 * MongoDb 客户端依赖注入,使用本Odm需要先进行依赖注入初始化
 * 它有依赖注入的基本功能
 * Class Di
 * @package MongoOdm
 * @property Di $instance
 * @property Client $client
 * @property Database $database
 */
class Di
{
    public $client; # 链接对象
    public $database;# 默认数据库
    private static $instance; //私有静态属性，存放该类的实例
    private static $container;

    /**
     *
     * Di constructor.
     * @param Client $client
     */
    private function __construct(Client $client, $database)
    {
        $this->client = $client;
        $this->database = $this->getDatabase($database);
    }

    /**
     * 依赖注入初始化
     * @param Client $client
     * @param string $database
     * @return Di
     */
    public static function init(Client $client, string $database): Di
    {
        self::$instance = new self($client, $database);
        return self::$instance;
    }

    /**
     * 获取客户端对象
     * @return Client
     */
    public function getClient()
    {
        return $this->client->selectCollection();
    }

    /**
     * 获取数据库对象
     * @param $name 数据库名字
     * @return Database
     */
    public function getDatabase($name)
    {
        return $this->client->selectDatabase($name);
    }

    /**
     * 获取集合对象
     * @param $name 集合名字
     * @return \MongoDB\Collection
     */
    public function getCollection($name)
    {
        return $this->database->selectCollection($name);
    }

    /**
     * 获取依赖注入
     * @return Di
     * @throws \Exception
     */
    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            throw new \Exception('MongoOdm error : Di not init.');
        }
        return self::$instance;
    }


    /**
     * 获取共享实例
     * @param $name
     * @return mixed
     */
    public static function getShared($name)
    {
        if (isset(self::$container[$name])) {
            return self::$container[$name];
        }
        # 托盘中没有,尝试初始化
        if (class_exists($name)) {
            self::$container[$name] = new $name;
            return self::$container[$name] ;
        }
        return null;
    }

}