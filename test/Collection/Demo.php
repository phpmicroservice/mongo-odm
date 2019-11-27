<?php

namespace test\Collection;

use MongoOdm\Collection;

class Demo extends Collection
{
    protected $_documentclass = \test\Document\Demo::class;

}