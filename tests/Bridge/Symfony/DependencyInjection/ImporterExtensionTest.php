<?php

namespace KunicMarko\Importer\Tests\Bridge\Symfony\DependencyInjection;

use KunicMarko\Importer\Bridge\Symfony\DependencyInjection\ImporterExtension;
use KunicMarko\Importer\Reader\XlsxReader;
use KunicMarko\Importer\Reader\XmlReader;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
class ImporterExtensionTest extends AbstractExtensionTestCase
{
    public function testLoadsFormServiceDefinition(): void
    {
        $this->container->setParameter('kernel.project_dir', 'test');
        $this->load();

        $this->assertContainerBuilderHasService(
            XlsxReader::class,
            XlsxReader::class
        );

        $this->assertContainerBuilderHasService(
            XmlReader::class
        );
    }

    protected function getContainerExtensions(): array
    {
        return [new ImporterExtension()];
    }
}
