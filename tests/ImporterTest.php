<?php

namespace KunicMarko\Importer\Tests;

use KunicMarko\Importer\ImportConfiguration as ImportConfigurationInterface;
use KunicMarko\Importer\ImporterFactory;
use KunicMarko\Importer\Reader\CsvReader;
use KunicMarko\Importer\Reader\XlsxReader;
use KunicMarko\Importer\Reader\JsonReader;
use KunicMarko\Importer\Reader\XmlReader;
use KunicMarko\Importer\Tests\Fixtures\ChunkImportConfiguration;
use KunicMarko\Importer\Tests\Fixtures\ImportConfiguration;
use KunicMarko\Importer\Tests\Fixtures\ImportNestedJsonConfiguration;
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

    /**
     * @var ImportConfigurationInterface
     */
    private $importConfiguration;

    public function setUp()
    {
        $this->importerFactory = new ImporterFactory();
        $this->importerFactory->addReader(new CsvReader());
        $this->importerFactory->addReader(new JsonReader());
        $this->importerFactory->addReader(new XlsxReader());
        $this->importerFactory->addReader(new XmlReader());

        $this->importConfiguration = new ImportConfiguration();
    }

    public function testCsvImportFromFile(): void
    {
        $importer = $this->importerFactory->getImporter('csv');

        $importer->fromFile(__DIR__ . '/Fixtures/fake.csv')
            ->useImportConfiguration($this->importConfiguration)
            ->import();
    }

    public function testCsvImportFromString(): void
    {
        $importer = $this->importerFactory->getImporter('csv');

        $importer->fromString(file_get_contents(__DIR__ . '/Fixtures/fake.csv'))
            ->useImportConfiguration($this->importConfiguration)
            ->import();
    }

    public function testXmlImportFromFile(): void
    {
        $importer = $this->importerFactory->getImporter('xml');

        $importer->fromFile(__DIR__ . '/Fixtures/fake.xml')
            ->useImportConfiguration($this->importConfiguration)
            ->import();
    }

    public function testXmlImportFromString(): void
    {
        $importer = $this->importerFactory->getImporter('xml');

        $importer->fromString(file_get_contents(__DIR__ . '/Fixtures/fake.xml'))
            ->useImportConfiguration($this->importConfiguration)
            ->import();
    }

    public function testJsonImportFromFile(): void
    {
        $importer = $this->importerFactory->getImporter('json');

        $importer->fromFile(__DIR__ . '/Fixtures/fake.json')
            ->useImportConfiguration($this->importConfiguration)
            ->import();
    }

    public function testJsonImportFromString(): void
    {
        $importer = $this->importerFactory->getImporter('json');

        $importer->fromString(file_get_contents(__DIR__ . '/Fixtures/fake.json'))
            ->useImportConfiguration($this->importConfiguration)
            ->import();
    }

    public function testNestedJsonImportFromFile(): void
    {
        $importer = $this->importerFactory->getImporter('json');

        $importer->fromFile(__DIR__ . '/Fixtures/fake_nested.json')
            ->useImportConfiguration(new ImportNestedJsonConfiguration())
            ->import();
    }

    public function testNestedJsonImportFromString(): void
    {
        $importer = $this->importerFactory->getImporter('json');

        $importer->fromString(file_get_contents(__DIR__ . '/Fixtures/fake_nested.json'))
            ->useImportConfiguration(new ImportNestedJsonConfiguration())
            ->import();
    }

    public function testExcelImportFromFile(): void
    {
        $importer = $this->importerFactory->getImporter('xlsx');

        $importer->fromFile(__DIR__ . '/Fixtures/fake.xlsx')
            ->useImportConfiguration($this->importConfiguration)
            ->import();
    }

    public function testWithAdditionalData(): void
    {
        $importer = $this->importerFactory->getImporter('xlsx');

        $importer->fromFile(__DIR__ . '/Fixtures/fake.xlsx')
            ->useImportConfiguration($this->importConfiguration)
            ->withAdditionalData(['test' => 'testing'])
            ->import();
    }

    /**
     * @expectedException \KunicMarko\Importer\Exception\NotSupportedException
     */
    public function testExcelImportFromString(): void
    {
        $importer = $this->importerFactory->getImporter('xlsx');

        $importer->fromString('nop')
            ->useImportConfiguration($this->importConfiguration)
            ->import();
    }

    public function testChunkImport(): void
    {
        $importer = $this->importerFactory->getImporter('csv');

        $importer->fromFile(__DIR__ . '/Fixtures/fake.csv')
            ->useImportConfiguration(new ChunkImportConfiguration())
            ->import();
    }

    /**
     * @expectedException \KunicMarko\Importer\Exception\InvalidArgumentException
     */
    public function testReaderNotFound(): void
    {
        $this->importerFactory->getImporter('fake');
    }

    /**
     * @expectedException \KunicMarko\Importer\Exception\InvalidArgumentException
     */
    public function testNoImportConfiguration(): void
    {
        $importer = $this->importerFactory->getImporter('csv');

        $importer->import();
    }

    /**
     * @expectedException \KunicMarko\Importer\Exception\InvalidArgumentException
     */
    public function testFileNotFound(): void
    {
        $importer = $this->importerFactory->getImporter('csv');

        $importer
            ->useImportConfiguration(new ChunkImportConfiguration())
            ->fromFile('fake');
    }

    /**
     * @expectedException \KunicMarko\Importer\Exception\InvalidArgumentException
     */
    public function testContentCantBeEmpty(): void
    {
        $importer = $this->importerFactory->getImporter('csv');

        $importer
            ->useImportConfiguration(new ChunkImportConfiguration())
            ->fromString('');
    }

    /**
     * @expectedException \KunicMarko\Importer\Exception\InvalidArgumentException
     */
    public function testJsonEmptyImport(): void
    {
        $importer = $this->importerFactory->getImporter('json');

        $importer
            ->useImportConfiguration(new ChunkImportConfiguration())
            ->import();
    }

    /**
     * @expectedException \KunicMarko\Importer\Exception\InvalidArgumentException
     */
    public function testXlsxEmptyImport(): void
    {
        $importer = $this->importerFactory->getImporter('xlsx');

        $importer
            ->useImportConfiguration(new ChunkImportConfiguration())
            ->import();
    }

    /**
     * @expectedException \KunicMarko\Importer\Exception\InvalidArgumentException
     */
    public function testCsvEmptyImport(): void
    {
        $importer = $this->importerFactory->getImporter('csv');

        $importer
            ->useImportConfiguration(new ChunkImportConfiguration())
            ->import();
    }

    /**
     * @expectedException \KunicMarko\Importer\Exception\InvalidArgumentException
     */
    public function testXmlEmptyImport(): void
    {
        $importer = $this->importerFactory->getImporter('xml');

        $importer
            ->useImportConfiguration(new ChunkImportConfiguration())
            ->import();
    }
}
