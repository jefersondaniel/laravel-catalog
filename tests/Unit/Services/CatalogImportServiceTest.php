<?php

namespace Tests\Unit\Services;

use App\CatalogImport;
use App\Jobs\ProcessCatalogImport;
use App\Repositories\CatalogImportRepository;
use App\Repositories\ProductRepository;
use App\Services\CatalogImportService;
use App\Services\SpreadsheetReaderService;
use App\Events\CatalogImportUpdated;
use Tests\TestCase;
use \Mockery as m;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Event;

class CatalogImportServiceTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test process import
     *
     * @return void
     */
    public function testProcessImport()
    {
        Queue::fake();
        Event::fake();
        $productData = ['lm' => 1001];
        $spreadsheetReaderService = m::mock(SpreadsheetReaderService::class)
            ->shouldReceive('readRows')->andReturn([$productData])
            ->getMock();
        $productRepository = m::mock(ProductRepository::class)
            ->shouldReceive('updateOrCreate')->once()
            ->getMock();
        $catalogImportRepository = m::mock(CatalogImportRepository::class)
            ->shouldIgnoreMissing();
        $catalogImport = new CatalogImport(['file' => 'test.xslx']);
        $catalogImportService = new CatalogImportService(
            $spreadsheetReaderService,
            $productRepository,
            $catalogImportRepository
        );
        $catalogImportService->processImport($catalogImport);
        Event::assertDispatched(CatalogImportUpdated::class, function ($e) use ($catalogImport) {
            return $e->catalogImport->lm === $catalogImport->lm;
        });
    }

    /**
     * Test process import emit event
     *
     * @return void
     */
    public function testCreate()
    {
        Queue::fake();
        $spreadsheetReaderService = m::mock(SpreadsheetReaderService::class)
            ->shouldIgnoreMissing();
        $productRepository = m::mock(ProductRepository::class)
            ->shouldIgnoreMissing();;
        $catalogImportRepository = m::mock(CatalogImportRepository::class)
            ->shouldIgnoreMissing();
        $catalogImportService = new CatalogImportService(
            $spreadsheetReaderService,
            $productRepository,
            $catalogImportRepository
        );
        $catalogImportService->create(new CatalogImport(['lm' => 1]));
        Queue::assertPushed(ProcessCatalogImport::class);
    }
}
