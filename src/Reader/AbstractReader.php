<?php

namespace KunicMarko\Importer\Reader;

use Iterator;
use KunicMarko\Importer\Exception\InvalidArgumentException;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
abstract class AbstractReader implements Reader
{
    /**
     * @var string
     */
    protected $filename;

    /**
     * @var string
     */
    protected $content;

    public function fromFile(string $filename): void
    {
        if (!file_exists($filename)) {
            throw new InvalidArgumentException('File not found.');
        }

        $this->filename = $filename;
    }

    public function fromString(string $content): void
    {
        if (!$content) {
            throw new InvalidArgumentException("Content can't be empty.");
        }

        $this->content = $content;
    }
}
