<?php

namespace KunicMarko\Importer\Reader;

use Iterator;
use KunicMarko\Importer\Exception\InvalidArgumentException;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
final class CsvReader extends AbstractReader
{
    public function getFormat(): string
    {
        return 'csv';
    }

    public function getItems(): Iterator
    {
        if (!$this->filename && !$this->content) {
            throw new InvalidArgumentException('Please provide a path to file or content from string.');
        }

        $file = $this->openFile();

        while (($row = fgetcsv($file)) !== false) {
            yield $row;
        }

        fclose($file);
    }

    private function openFile()
    {
        if ($this->filename) {
            return fopen($this->filename, 'rb');
        }

        $file = fopen('php://temp', 'rb+');
        fwrite($file, $this->content);
        rewind($file);

        return $file;
    }
}
