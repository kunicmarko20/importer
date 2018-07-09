<?php

namespace KunicMarko\Importer\Reader;

use Iterator;
use ArrayIterator;
use KunicMarko\Importer\Exception\InvalidArgumentException;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
final class JsonReader extends AbstractReader
{
    public function getFormat(): string
    {
        return 'json';
    }

    public function getItems(): Iterator
    {
        if (!$this->filename && !$this->content) {
            throw new InvalidArgumentException('Please provide a path to file or content from string.');
        }

        return new ArrayIterator(json_decode(
            $this->filename ? file_get_contents($this->filename) : $this->content,
            true
        ));
    }
}
