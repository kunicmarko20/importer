<?php

namespace KunicMarko\Importer\Reader;

use Iterator;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
interface Reader
{
    public function getFormat(): string;
    public function load(string $filename): void;
    public function getItems(): Iterator;
}
