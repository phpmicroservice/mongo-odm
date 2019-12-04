<?php

namespace test\Collection;

use MongoOdm\Collection;

class Demo1 extends Collection
{
    protected $_documentclass = \test\Document\Demo::class;

}