<?php

namespace KunicMarko\Importer\Tests\Bridge\Laravel;

use KunicMarko\Importer\Bridge\Laravel\ImporterServiceProvider;
use KunicMarko\Importer\Importer;
use KunicMarko\Importer\ImporterFactory;
use KunicMarko\Importer\Reader\CsvReader;
use Orchestra\Testbench\TestCase;

class ImporterServiceProviderTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [ImporterServiceProvider::class];
    }

    public function testServiceExists(): void
    {
        /** @var ImporterFactory $factory */
        $factory = $this->app[ImporterFactory::class];

        $this->assertInstanceOf(ImporterFactory::class, $factory);
        $this->assertInstanceOf(Importer::class, $importer = $factory->getImporter('csv'));
        $this->assertAttributeInstanceOf(CsvReader::class, 'reader', $importer);
        $this->assertInstanceOf(CsvReader::class, $this->app[CsvReader::class]);
    }
}
