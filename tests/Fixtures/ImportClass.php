<?php

namespace KunicMarko\Importer\Tests\Fixtures;

use Iterator;
use KunicMarko\Importer\BeforeImport;
use KunicMarko\Importer\Import;
use PHPUnit\Framework\TestCase;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
class ImportClass extends TestCase implements Import, BeforeImport
{
    public function before(Iterator $items, array $additionalData): Iterator
    {
        $items->next();

        return $items;
    }

    public function map(array $item, array $additionalData)
    {
        if ($additionalData) {
            $this->assertSame('testing', reset($additionalData));
        }

        return $item;
    }

    public function save(array $items, array $additionalData): void
    {
        $this->assertCount(999, $items);

        $first = reset($items);
        $this->assertSame(2, (int) reset($first));
    }
}
