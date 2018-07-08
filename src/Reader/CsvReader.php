<?php

namespace KunicMarko\Importer\Reader;

use Iterator;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
final class CsvReader implements Reader
{
    /**
     * @var string
     */
    private $filename;

    public function getFormat(): string
    {
        return 'csv';
    }

    public function load(string $filename): void
    {
        if (!file_exists($filename)) {
            throw new \InvalidArgumentException('File not found.');
        }

        $this->filename = $filename;
    }

    public function getItems(): Iterator
    {
        $file = fopen($this->filename, 'rb');

        while (($row = fgetcsv($file)) !== false) {
            yield $row;
        }

        fclose($file);
    }
}
