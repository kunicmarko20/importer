# UPGRADE

UPGRADE FROM 0.1.0 to 0.2.0
===========================

`KunicMarko\Importer\Import` has been renamed to `KunicMarko\Importer\ImportConfiguration`.

`Importer::useImportClass` has been renamed to `Importer::useImportConfiguration`.

`Importer::import` now throws exception if ImportConfiguration is not provided.

`BeforeImport::before` now accepts second parameter `$additionalData`.
`ImportConfiguration::map` now accepts second parameter `$additionalData`.
`ImportConfiguration::save` now accepts second parameter `$additionalData`.

New method `Importer::withAdditionalData` that allows you to pass any additional data
you need to get into your import class.

