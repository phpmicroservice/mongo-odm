<?php

namespace test\Document;

use MongoOdm\Document;

class Demo extends Document
{

    protected static $_collection_class = \test\Collection\Demo::class;
}