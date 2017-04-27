<?php

namespace App\Validation;

use App\Services\SpreadsheetReaderService;
use Illuminate\Http\UploadedFile;

class SpreadsheetValidator
{
    /**
     * @var SpreadsheetReaderService
     */
    protected $spreadsheetReaderService;

    /**
     * Constructs a new validator
     *
     * @param SpreadsheetReaderService $spreadsheetReaderService
     * @return void
     */
    public function __construct(SpreadsheetReaderService $spreadsheetReaderService)
    {
        $this->spreadsheetReaderService = $spreadsheetReaderService;
    }

    /**
     * Validate if a uploaded file is a spreadsheet
     *
     * @param $string $attribute
     * @param UploadedFile $value
     * @return void
     */
    public function validate($attribute, $value)
    {
        if (! $value instanceof UploadedFile || ! $value->isValid()) {
            return false;
        }

        return $this->spreadsheetReaderService->isValidFile($value);
    }
}
