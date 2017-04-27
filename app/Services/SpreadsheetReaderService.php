<?php

namespace App\Services;

use PHPExcel_IOFactory;

class SpreadsheetReaderService
{
    /**
     * Identify if the given filename has a valid spreadsheet
     *
     * @param string $filename
     * @return boolean
     */
    public function isValidFile($filename)
    {
        $supportedTypes = [
            'Excel2007',
            'Excel5'
        ];
        $valid = false;
        foreach ($supportedTypes as $type) {
            $reader = $this->createReader($type);
            if ($reader && $reader->canRead($filename)) {
                $valid = true;
                break;
            }
        }
        return $valid;
    }

    /**
     * Read spreadsheet rows after identify where the header is
     *
     * @param string $filename
     * @param array $columnNames
     * @return Generator
     */
    public function readRows($filename, array $columnNames)
    {
        $excel = $this->load($filename);
        $sheet = $excel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $header = null;
        $headerLength = null;
        $rows = [];
        for ($row = 1; $row <= $highestRow; $row++){
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);
            if (! $header && $this->isHeaderRow($rowData, $columnNames)) {
                $header = array_filter($rowData[0]);
                $headerLength = count($header);
                continue;
            }
            if (! $header) {
                continue;
            }
            $slicedRow = array_slice($rowData[0], 0, $headerLength);
            yield array_combine($header, $slicedRow);
        }
    }

    /**
     * Checks if a row is the header of a document
     *
     * @param array $rowData
     * @param array $columnNames
     * @return boolean
     */
    protected function isHeaderRow(array $rowData, array $columnNames)
    {
        $foundNames = array_filter($rowData[0]);
        return count($foundNames) && count(array_diff($foundNames, $columnNames)) === 0;
    }

    /**
     * Create reader
     *
     * @param string $type
     * @return PHPExcel_Reader_IReader
     */
    protected function createReader($type)
    {
        return PHPExcel_IOFactory::createReader($type);
    }

    /**
     * Load spreadsheet file
     *
     * @param string $filename
     * @return PHPExcel
     */
    protected function load($filename)
    {
        return PHPExcel_IOFactory::load($filename);
    }
}
