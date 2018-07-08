<?php

namespace KunicMarko\Importer;

use KunicMarko\Importer\Reader\Reader;
use Iterator;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
final class Importer
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var Import
     */
    private $importClass;

    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function load($file): void
    {
        $this->reader->load($file);
    }

    public function useImportClass(Import $importClass): void
    {
        $this->importClass = $importClass;
    }

    public function import(): void
    {
        $items = $this->reader->getItems();

        if ($this->importClass instanceof BeforeImport) {
            $this->importClass->before($items);
        }

        if ($this->importClass instanceof ChunkImport) {
            $this->importChunkItems(
                $items,
                $this->importClass->chunkSize()
            );
            return;
        }

        $this->importItems($items);
    }

    private function importChunkItems(Iterator $items, int $chunkSize): void
    {
        $mappedItems = [];

        $i = 0;

        foreach ($items as $item) {
            $mappedItems[] = $this->importClass->map($item);

            if (++$i === $chunkSize) {
                $this->importClass->save($mappedItems);
                $mappedItems = [];
                $i = 0;
            }
        }

        $this->importClass->save($mappedItems);
    }

    private function importItems(Iterator $items): void
    {
        $mappedItems = [];

        foreach ($items as $item) {
            $mappedItems[] = $this->importClass->map($item);
        }

        $this->importClass->save($mappedItems);
    }
}
