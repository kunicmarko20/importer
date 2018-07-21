<?php

namespace KunicMarko\Importer;

use Iterator;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
interface BeforeImport
{
    public function before(Iterator $items, array $additionalData): Iterator;
}
