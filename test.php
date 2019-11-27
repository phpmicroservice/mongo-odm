<?php
# 测试脚手架
include_once "vendor/autoload.php";

$load = new \Composer\Autoload\ClassLoader();
$load->addPsr4('test\\', 'test');
$load->register();
# 进行di初始化
$mongo = new MongoDB\Client(
    'mongodb://mongoadmin:mongoadmin@192.168.0.201:27017/admin'
);
\MongoOdm\Di::init($mongo, 'test');