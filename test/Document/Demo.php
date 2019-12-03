<?php

namespace test\Document;

use MongoOdm\Document\Document;

class Demo extends Document
{

    protected $_collection_class = \test\Collection\Demo::class;
    public static $intt = 0;

    public function initialize()
    {
        self::$intt++;
    }
}