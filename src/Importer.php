<?php

namespace KunicMarko\Importer;

use KunicMarko\Importer\Exception\InvalidArgumentException;
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
     * @var ImportConfiguration
     */
    private $importConfiguration;

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

    public function useImportConfiguration(ImportConfiguration $importConfiguration): self
    {
        $this->importConfiguration = $importConfiguration;

        return $this;
    }

    public function import(): void
    {
        if (!$this->importConfiguration) {
            throw new InvalidArgumentException('You must provide ImportConfiguration.');
        }

        $items = $this->reader->getItems();

        if ($this->importConfiguration instanceof BeforeImport) {
            $items = $this->importConfiguration->before($items, $this->additionalData);
        }

        if ($this->importConfiguration instanceof ChunkImport) {
            $this->importChunkItems(
                $items,
                $this->importConfiguration->chunkSize()
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
            $mappedItems[] = $this->importConfiguration->map($items->current(), $this->additionalData);

            if (++$i === $chunkSize) {
                $this->importConfiguration->save($mappedItems, $this->additionalData);
                $mappedItems = [];
                $i = 0;
            }
        }

        if ($mappedItems) {
            $this->importConfiguration->save($mappedItems, $this->additionalData);
        }
    }

    private function importItems(Iterator $items): void
    {
        $mappedItems = [];

        for (; $items->valid(); $items->next()) {
            $mappedItems[] = $this->importConfiguration->map($items->current(), $this->additionalData);
        }

        $this->importConfiguration->save($mappedItems, $this->additionalData);
    }
}
