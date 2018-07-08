<?php

namespace KunicMarko\Importer;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
interface ChunkImport
{
    public function chunkSize(): int;
}
