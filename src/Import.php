<?php

namespace KunicMarko\Importer;

interface Import
{
    public function map(array $item);
    public function save(array $items): void;
}
