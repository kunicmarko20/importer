<?php

namespace KunicMarko\Importer;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
interface Import
{
    public function map(array $item);
    public function save(array $items): void;
}
