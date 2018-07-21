# UPGRADE

UPGRADE FROM 0.1.0 to 0.2.0
===========================

`BeforeImport::before` now accepts second parameter `$additionalData`.
`Import::map` now accepts second parameter `$additionalData`.
`Import::save` now accepts second parameter `$additionalData`.

New method `Importer::withAdditionalData` that allows you to pass any additional data
you need to get into your import class.
