<?php

namespace KunicMarko\Importer\Tests;

use KunicMarko\Importer\ImporterFactory;
use KunicMarko\Importer\Reader\CsvReader;
use KunicMarko\Importer\Tests\Fixtures\ImportClass;
use PHPUnit\Framework\TestCase;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
class ImporterTest extends TestCase
{
    /**
     * @var ImporterFactory
     */
    private $importerFactory;

    public function setUp()
    {
        $this->importerFactory = new ImporterFactory();
        $this->importerFactory->addReader(new CsvReader());
    }

    public function testCsvImport(): void
    {
        $importer = $this->importerFactory->getImporter('csv');

        $importer->load(__DIR__ . '/Fixtures/fake.csv')
            ->useImportClass(new ImportClass())
            ->import();
    }
}
