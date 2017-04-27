<?php

namespace Tests\Unit\Services;

use App\Services\SpreadsheetReaderService;
use Tests\TestCase;
use \Mockery as m;

class SpreadsheetReaderServiceTest extends TestCase
{
    /**
     * Test file validation
     */
    public function testIsValidFile()
    {
        $reader = m::mock('PHPExcel_Reader_IReader')
            ->shouldReceive('canRead')->once()->andReturn(true)
            ->getMock();
        $service = m::mock(SpreadsheetReaderService::class . '[createReader]')
            ->shouldAllowMockingProtectedMethods()
            ->shouldReceive('createReader')->once()->andReturn($reader)
            ->getMock();
        $isValid = $service->isValidFile('example.xlxs');
        $this->assertTrue($isValid);
    }

    /**
     * Test file reading
     */
    public function testReadRows()
    {
        $sheet = m::mock('PHPExcel_Worksheet')
            ->shouldIgnoreMissing()
            ->shouldReceive('getHighestRow')->once()->andReturn(4)
            ->shouldReceive('getHighestColumn')->once()->andReturn('F')
            ->shouldReceive('rangeToArray')->withArgs(['A1:F1', null, true, false])
            ->andReturn([[null, null, null, null, null, null]])
            ->shouldReceive('rangeToArray')->withArgs(['A2:F2', null, true, false])
            ->andReturn([['A', 'B', 'C', null, null, null]])
            ->shouldReceive('rangeToArray')->withArgs(['A3:F3', null, true, false])
            ->andReturn([['John', '21', 'M', null, null, null]])
            ->shouldReceive('rangeToArray')->withArgs(['A4:F4', null, true, false])
            ->andReturn([['Mary', '34', 'F', null, null, null]])
            ->getMock();
        $excel = m::mock('PHPExcel')
            ->shouldIgnoreMissing()
            ->shouldReceive('getSheet')->once()->andReturn($sheet)
            ->getMock();
        $service = m::mock(SpreadsheetReaderService::class . '[load]')
            ->shouldAllowMockingProtectedMethods()
            ->shouldReceive('load')->once()->andReturn($excel)
            ->getMock();
        $rows = $service->readRows('example.xlxs', ['A', 'B', 'C']);
        $this->assertEquals(
            [
                ['A' => 'John', 'B' => '21', 'C' => 'M'],
                ['A' => 'Mary', 'B' => '34', 'C' => 'F']
            ],
            iterator_to_array($rows)
        );
    }
}
