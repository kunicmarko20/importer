<?php

namespace KunicMarko\Importer\Reader;

use Iterator;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
interface Reader
{
    public function getFormat(): string;
    public function fromFile(string $filename): void;
    public function fromString(string $content): void;
    public function getItems(): Iterator;
}
