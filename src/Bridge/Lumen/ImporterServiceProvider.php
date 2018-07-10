<?php

namespace KunicMarko\Importer\Bridge\Lumen;

use Illuminate\Support\ServiceProvider;
use KunicMarko\Importer\ImporterFactory;
use KunicMarko\Importer\Reader\CsvReader;
use KunicMarko\Importer\Reader\JsonReader;
use KunicMarko\Importer\Reader\XmlReader;
use KunicMarko\Importer\Reader\XlsxReader;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
final class ImporterServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ImporterFactory::class, function ($app) {
            $factory = new ImporterFactory();

            $factory->addReader($app->make(CsvReader::class));
            $factory->addReader($app->make(JsonReader::class));
            $factory->addReader($app->make(XmlReader::class));

            if (class_exists(Xlsx::class)) {
                $factory->addReader($app->make(XlsxReader::class));
            }

            return $factory;
        });
    }
}
