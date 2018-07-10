<?php

namespace KunicMarko\Importer\Reader;

use Iterator;
use KunicMarko\Importer\Exception\InvalidArgumentException;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
final class XmlReader extends AbstractReader
{
    public function getFormat(): string
    {
        return 'xml';
    }

    public function getItems(): Iterator
    {
        if (!$this->filename && !$this->content) {
            throw new InvalidArgumentException('Please provide a path to file or content from string.');
        }

        $elements = simplexml_load_string(
            $this->filename
                ? file_get_contents($this->filename)
                : $this->content
        );

        foreach ($elements as $element) {
            yield (array) $element;
        }
    }
}
