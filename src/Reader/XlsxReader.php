<?php

namespace KunicMarko\Importer\Reader;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Iterator;
use ArrayIterator;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
final class XlsxReader implements Reader
{
    /**
     * @var string
     */
    private $filename;

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

    public function load(string $filename): void
    {
        if (!file_exists($filename)) {
            throw new \InvalidArgumentException('File not found.');
        }

        $this->filename = $filename;
    }

    public function getItems(): Iterator
    {
        if (!$this->filename) {
            throw new \InvalidArgumentException('Please provide a path to file.');
        }

        $spreadsheet = $this->xlsxReader->load($this->filename);

        return new ArrayIterator($spreadsheet->getActiveSheet()->toArray());
    }
}
