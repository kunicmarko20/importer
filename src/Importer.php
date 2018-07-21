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

    /**
     * @var array
     */
    private $additionalData = [];

    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function fromFile(string $filename): self
    {
        $this->reader->fromFile($filename);

        return $this;
    }

    public function fromString(string $content): self
    {
        $this->reader->fromString($content);

        return $this;
    }

    public function withAdditionalData(array $additionalData): self
    {
        $this->additionalData = $additionalData;

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
            $items = $this->importClass->before($items, $this->additionalData);
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
            $mappedItems[] = $this->importClass->map($items->current(), $this->additionalData);

            if (++$i === $chunkSize) {
                $this->importClass->save($mappedItems, $this->additionalData);
                $mappedItems = [];
                $i = 0;
            }
        }

        if ($mappedItems) {
            $this->importClass->save($mappedItems, $this->additionalData);
        }
    }

    private function importItems(Iterator $items): void
    {
        $mappedItems = [];

        for (; $items->valid(); $items->next()) {
            $mappedItems[] = $this->importClass->map($items->current(), $this->additionalData);
        }

        $this->importClass->save($mappedItems, $this->additionalData);
    }
}
