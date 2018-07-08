<?php

namespace KunicMarko\Importer\Tests\Fixtures;

use KunicMarko\Importer\ChunkImport;
use KunicMarko\Importer\Import;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
class ChunkImportClass implements Import, ChunkImport
{
    public function chunkSize(): int
    {
        // TODO: Implement chunkSize() method.
    }

    public function map(array $item)
    {
        // TODO: Implement map() method.
    }

    public function save(array $items): void
    {
        // TODO: Implement save() method.
    }

}
