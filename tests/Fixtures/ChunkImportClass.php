<?php

namespace KunicMarko\Importer\Tests\Fixtures;

use KunicMarko\Importer\ChunkImport;
use KunicMarko\Importer\Import;
use PHPUnit\Framework\TestCase;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
class ChunkImportClass extends TestCase implements Import, ChunkImport
{
    public function chunkSize(): int
    {
        return 50;
    }

    public function map(array $item)
    {
        return $item;
    }

    public function save(array $items): void
    {
        $this->assertCount(50, $items);
    }
}
