<?php

namespace KunicMarko\Importer\Tests\Fixtures;

use Iterator;
use ArrayIterator;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
class ImportNestedJsonClass extends ImportClass
{
    /**
     * @param ArrayIterator|Iterator $items
     * @return Iterator
     */
    public function before(Iterator $items): Iterator
    {
        $iterator = new ArrayIterator($items->getArrayCopy()['data']);

        $iterator->next();

        return $iterator;
    }
}
