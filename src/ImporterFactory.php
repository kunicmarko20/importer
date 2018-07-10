<?php

namespace KunicMarko\Importer;

use KunicMarko\Importer\Exception\InvalidArgumentException;
use KunicMarko\Importer\Reader\Reader;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
final class ImporterFactory
{
    /**
     * @var Importer[]
     */
    private $importers;

    public function getImporter(string $format): Importer
    {
        if (!array_key_exists($format, $this->importers)) {
            throw new InvalidArgumentException(sprintf(
                'Invalid "%s" format, supported formats are : "%s"',
                $format,
                implode(', ', array_keys($this->importers))
            ));
        }

        return $this->importers[$format];
    }

    public function addReader(Reader $reader): void
    {
        $this->importers[$reader->getFormat()] = new Importer($reader);
    }
}
