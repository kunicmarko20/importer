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

    public function load(string $filename): self
    {
        $this->reader->load($filename);

        return $this;
    }

    public function useImportClass(Import $importClass): self
    {
        $this->importClass = $importClass;

        return $this;
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

        for (; $items->valid(); $items->next()) {
            $mappedItems[] = $this->importClass->map($a = $items->current());

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

        for (; $items->valid(); $items->next()) {
            $mappedItems[] = $this->importClass->map($items->current());
        }

        $this->importClass->save($mappedItems);
    }
}
