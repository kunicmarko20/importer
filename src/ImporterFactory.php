<?php

namespace KunicMarko\Importer;

use KunicMarko\Importer\Reader\Reader;
use RuntimeException;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
final class ImporterFactory
{
    /**
     * @var Reader[]
     */
    private $readers;

    public function getImporter(string $format): Importer
    {
        if (!array_key_exists($format, $this->readers)) {
            throw new RuntimeException(sprintf(
                'Invalid "%s" format, supported formats are : "%s"',
                $format,
                implode(', ', array_keys($this->readers))
            ));
        }

        return new Importer($this->readers[$format]);
    }

    public function addReader(Reader $reader): void
    {
        $this->readers[$reader->getFormat()] = $reader;
    }
}
