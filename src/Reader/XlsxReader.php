<?php

namespace KunicMarko\Importer\Reader;

use KunicMarko\Importer\Exception\InvalidArgumentException;
use KunicMarko\Importer\Exception\NotSupportedException;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Iterator;
use ArrayIterator;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
final class XlsxReader extends AbstractReader
{
    /**
     * @var Xlsx
     */
    private $xlsxReader;

    public function __construct(Xlsx $xlsxReader = null)
    {
        $this->xlsxReader = $xlsxReader ?? new Xlsx();
    }

    public function getFormat(): string
    {
        return 'xlsx';
    }

    public function fromString(string $content): void
    {
        throw new NotSupportedException('Import from string is not supported for xslx.');
    }

    public function getItems(): Iterator
    {
        if (!$this->filename) {
            throw new InvalidArgumentException('Please provide a path to file.');
        }

        $spreadsheet = $this->xlsxReader->load($this->filename);

        return new ArrayIterator($spreadsheet->getActiveSheet()->toArray());
    }
}
