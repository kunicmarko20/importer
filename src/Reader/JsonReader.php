<?php

namespace KunicMarko\Importer\Reader;

use Iterator;
use InvalidArgumentException;
use ArrayIterator;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
final class JsonReader implements Reader
{
    /**
     * @var string
     */
    private $filename;

    public function getFormat(): string
    {
        return 'json';
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
        if (!$this->filename) {
            throw new InvalidArgumentException('Please provide a path to file.');
        }

        return new ArrayIterator(json_decode(
            file_get_contents($this->filename),
            true
        ));
    }
}
