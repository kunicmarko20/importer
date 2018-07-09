<?php

namespace KunicMarko\Importer\Bridge\Symfony\DependencyInjection;

use KunicMarko\Importer\ImporterFactory;
use KunicMarko\Importer\Reader\XlsxReader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
final class ImporterExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        if (class_exists(Xlsx::class)) {
            $container->setDefinition(
                XlsxReader::class,
                $xlsxReaderDefinition = new Definition(XlsxReader::class)
            );

            $container->getDefinition(ImporterFactory::class)
                ->addMethodCall('addReader', [$xlsxReaderDefinition]);
        }
    }
}
