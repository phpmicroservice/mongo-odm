<?php

namespace test\Type;

use MongoDB\BSON\ObjectId;
use MongoOdm\Document\NativeInterface;
use MongoOdm\TypeInterface;

/**
 * 自定义类型
 * Class A1
 * @package test\Type
 */
class A1 implements NativeInterface
{
    private $data;

    public function __construct(int $data = 0)
    {
        if (!$data) {
            $data = time() + mt_rand(0, 99999);
        }
        $this->data = [
            'int' => $data
        ];
    }

    public function demo()
    {
        new ObjectId();
    }


    public function get2(): int
    {
        return $this->data['int'] * 2;
    }

    public function get3()
    {
        return $this->data['int'] * 3;
    }

    public function bsonSerialize()
    {
        return $this->data;

    }

    public function bsonUnserialize(array $data)
    {
        $this->data = $data;
    }


}