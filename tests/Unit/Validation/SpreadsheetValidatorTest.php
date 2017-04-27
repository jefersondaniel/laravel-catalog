<?php

namespace Tests\Unit\Services;

use App\Services\SpreadsheetReaderService;
use App\Validation\SpreadsheetValidator;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use \Mockery as m;

class SpreadsheetValidatorTest extends TestCase
{
    /**
     * Test failed validation
     */
    public function testIsValidFileFail()
    {
        $service = m::mock(SpreadsheetReaderService::class)
            ->shouldIgnoreMissing();
        $validator = new SpreadsheetValidator($service);
        $this->assertFalse($validator->validate('test', 'test'));
    }

    /**
     * Test successful validation
     */
    public function testIsValidFileSuccess()
    {
        $service = m::mock(SpreadsheetReaderService::class)
            ->shouldReceive('isValidFile')->andReturn(true)
            ->getMock();
        $file = m::mock(UploadedFile::class)
            ->shouldReceive('isValid')->andReturn(true)
            ->getMock();
        $validator = new SpreadsheetValidator($service);
        $this->assertTrue($validator->validate('test', $file));
    }
}
