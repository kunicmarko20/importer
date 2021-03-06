Importer
========

Easier import from multiple file types (csv, json, xml, excel).

Support for Symfony, Lumen and Laravel.

[![PHP Version](https://img.shields.io/badge/php-%5E7.1-blue.svg)](https://img.shields.io/badge/php-%5E7.1-blue.svg)
[![Latest Stable Version](https://poser.pugx.org/kunicmarko/importer/v/stable)](https://packagist.org/packages/kunicmarko/importer)
[![Latest Unstable Version](https://poser.pugx.org/kunicmarko/importer/v/unstable)](https://packagist.org/packages/kunicmarko/importer)

[![Build Status](https://travis-ci.org/kunicmarko20/importer.svg?branch=master)](https://travis-ci.org/kunicmarko20/importer)
[![Coverage Status](https://coveralls.io/repos/github/kunicmarko20/importer/badge.svg?branch=master)](https://coveralls.io/github/kunicmarko20/importer?branch=master)

Documentation
-------------

* [Installation](#installation)
    * [Symfony](#symfony)
    * [Laravel](#laravel)
    * [Lumen](#lumen)
    * [Without Framework](#without-framework)
* [How to use](#how-to-use)
    * [ImportConfiguration](#importconfiguration)
        * [BeforeImport](#beforeimport)
        * [ChunkImport](#chunkimport)
    * [Import](#import)
        * [Import From File](#import-from-file)
        * [Import From String](#import-from-string)
    * [Pass Additional Data](#pass-additional-data)
* [Extending](#extending)

## Installation

**1.**  Add dependency with composer

```bash
composer require kunicmarko/importer
```

### Symfony

Register the bundle in your `config/bundles.php`

```php
return [
    //...
    KunicMarko\Importer\Bridge\Symfony\ImporterBundle::class => ['all' => true],
];
```

> By default, excel import is disabled, install "phpoffice/phpspreadsheet" to enable it.

### Laravel

Register the service provider in your `config/app.php`

```php
providers' => [
    //...
    KunicMarko\Importer\Bridge\Laravel\ImporterServiceProvider::class,
],
```

> By default, excel import is disabled, install "phpoffice/phpspreadsheet" to enable it.

### Lumen

Register the service provider in your `bootstrap/app.php`

```php
$app->register(KunicMarko\Importer\Bridge\Lumen\ImporterServiceProvider::class);
```

> By default, excel import is disabled, install "phpoffice/phpspreadsheet" to enable it.

### Without Framework

Add the Readers you want to use to a Factory and get your Importer:

```php
use KunicMarko\Importer\ImporterFactory;
use KunicMarko\Importer\Reader\CsvReader;
use KunicMarko\Importer\Reader\JsonReader;
use KunicMarko\Importer\Reader\XmlReader;
use KunicMarko\Importer\Reader\XlsxReader;

$importerFactory = new ImporterFactory();

$importerFactory->addReader(new CsvReader());
$importerFactory->addReader(new JsonReader());
$importerFactory->addReader(new XmlReader());
$importerFactory->addReader(new XlsxReader());

$importer = $importerFactory->getImporter('csv');
$importer->fromString('some,csv,string')
    ->useImportConfiguration(new YourImportConfiguration())
    ->import();
```

> If you want to use excel import, install "phpoffice/phpspreadsheet".

## How to use

### ImportConfiguration

ImportConfiguration defines how should the data be mapped and saves the data.
They have to implement `KunicMarko\Importer\ImportConfiguration` interface.

```php
use KunicMarko\Importer\ImportConfiguration;

class ImportUserConfiguration implements ImportConfiguration
{
    public function map(array $item, array $additionalData)
    {
        $user = new User();
        
        $user->setUsername($item['username']);
        //..

        return $user;
    }

    public function save(array $items, array $additionalData): void
    {
        //save your users
    }
}
```

#### BeforeImport

BeforeImport allows your ImportConfiguration to do something with data before the mapping starts.

```php
use KunicMarko\Importer\ImportConfiguration;
use KunicMarko\Importer\BeforeImport;
use Iterator;

class ImportSomethingConfiguration implements ImportConfiguration, BeforeImport
{
    public function before(Iterator $items, array $additionalData): Iterator
    {
        //start from 2nd line
        $items->next();

        return $items;
    }
}
```

#### ChunkImport

ChunkImport allows your configuration to define a number of items that the save method will
receive, instead of receiving all at once.

```php

use KunicMarko\Importer\ImportConfiguration;
use KunicMarko\Importer\ChunkImport;

class ImportChunkSomethingConfiguration implements ImportConfiguration, ChunkImport
{
    public function chunkSize(): int
    {
        return 50;
    }

    public function save(array $items, array $additionalData): void
    {
        //save will be called multiple times with 50 or less items
    }
}
```

### Import

After you have defined your import configuration, you can import from a file or from a string.
You HAVE to provide one of those 2 options and your import configuration.

#### Import From File

```php
use KunicMarko\Importer\ImporterFactory;

class UserImport
{
    private $importerFactory;

    public function __construct(ImporterFactory $importerFactory)
    {
        $this->importerFactory = $importerFactory;
    }
    
    public function import()
    {
        $importer = $importerFactory->getImporter('csv');

        $importer->fromFile('path/to/file.csv')
            ->useImportConfiguration(new YourImportConfiguration())
            ->import();
    }
}
```

#### Import From String

```php
use KunicMarko\Importer\ImporterFactory;

class UserImport
{
    private $importerFactory;

    public function __construct(ImporterFactory $importerFactory)
    {
        $this->importerFactory = $importerFactory;
    }
    
    public function import()
    {
        $importer = $importerFactory->getImporter('csv');

        $importer->fromString('some,csv,string')
            ->useImportConfiguration(new YourImportConfiguration())
            ->import();
    }
}
```

> Excel import does not support import from a string.

### Pass Additional Data

Sometimes you may want to pass additional data to your import configuration.

```php
use KunicMarko\Importer\ImporterFactory;

class UserImport
{
    private $importerFactory;

    public function __construct(ImporterFactory $importerFactory)
    {
        $this->importerFactory = $importerFactory;
    }
    
    public function import()
    {
        $importer = $importerFactory->getImporter('csv');

        $importer->fromString('some,csv,string')
            ->useImportConfiguration(new YourImportConfiguration())
            ->withAdditionalData(['user' => 'kunicmarko20'])
            ->import();
    }
}
```

## Extending

You can always add your own custom readers, just implement `KunicMarko\Importer\Reader\Reader`
interface and call `addReader()` method on ImporterFactory.
