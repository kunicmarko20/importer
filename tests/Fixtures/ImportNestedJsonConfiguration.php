<?php

namespace KunicMarko\Importer\Tests\Fixtures;

use Iterator;
use ArrayIterator;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
class ImportNestedJsonConfiguration extends ImportConfiguration
{
    /**
     * @param ArrayIterator|Iterator $items
     */
    public function before(Iterator $items, array $additionalData): Iterator
    {
        $iterator = new ArrayIterator($items->getArrayCopy()['data']);

        $iterator->next();

        return $iterator;
    }
}
