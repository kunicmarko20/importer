# CHANGELOG

## [0.2.0](https://github.com/kunicmarko20/importer/compare/0.1.0...0.2.0) - 2018-07-22
### Added
- Added `Importer::withAdditionalData` that allows you to pass any additional data
 to your import configuration
- `Importer::import` now throws exception if ImportConfiguration is not provided.

### Changed
- `KunicMarko\Importer\Import` has been renamed to `KunicMarko\Importer\ImportConfiguration`.
- `Importer::useImportClass` has been renamed to `Importer::useImportConfiguration`.
- `BeforeImport::before` now accepts second parameter `$additionalData`.
- `ImportConfiguration::map` now accepts second parameter `$additionalData`.
- `ImportConfiguration::save` now accepts second parameter `$additionalData`.
