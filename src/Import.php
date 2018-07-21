<?php

namespace KunicMarko\Importer;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
interface Import
{
    public function map(array $item, array $additionalData);
    public function save(array $items, array $additionalData): void;
}
