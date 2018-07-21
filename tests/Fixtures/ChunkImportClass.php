<?php

namespace KunicMarko\Importer\Tests\Fixtures;

use Iterator;
use KunicMarko\Importer\BeforeImport;
use KunicMarko\Importer\ChunkImport;
use KunicMarko\Importer\Import;
use PHPUnit\Framework\TestCase;
use function count;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
class ChunkImportClass extends TestCase implements Import, ChunkImport, BeforeImport
{
    public function before(Iterator $items, array $additionalData): Iterator
    {
        $items->next();

        return $items;
    }

    public function chunkSize(): int
    {
        return 50;
    }

    public function map(array $item, array $additionalData)
    {
        return $item;
    }

    public function save(array $items, array $additionalData): void
    {
        $this->assertLessThanOrEqual(50, count($items));
    }
}
