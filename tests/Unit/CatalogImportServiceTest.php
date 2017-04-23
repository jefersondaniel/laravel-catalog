<?php

namespace Tests\Unit;

use App\CatalogImport;
use App\Services\CatalogImportService;
use App\Services\SpreadsheetReaderService;
use App\Repositories\CatalogImportRepository;
use App\Repositories\ProductRepository;
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
     * Setup testing
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        Queue::fake();
        Event::fake();
        $productData = ['lm' => 1001];
        $spreadsheetReaderService = m::mock(SpreadsheetReaderService::class)
            ->shouldIgnoreMissing();
        $spreadsheetReaderService->shouldReceive('readRows')->andReturn([
            $productData
        ]);
        $this->app->instance(SpreadsheetReaderService::class, $spreadsheetReaderService);
        $productRepository = m::mock(ProductRepository::class)
            ->shouldIgnoreMissing();
        $this->app->instance(ProductRepository::class, $productRepository);
        $catalogImportRepository = m::mock(CatalogImportRepository::class)
            ->shouldIgnoreMissing();
        $this->app->instance(CatalogImportRepository::class, $catalogImportRepository);
    }

    /**
     * Test process import store products
     *
     * @return void
     */
    public function testProcessImportStoreProducts()
    {
        $catalogImportService = $this->app->make(CatalogImportService::class);
        $productService = $this->app->make(ProductRepository::class);
        $productService->shouldReceive('updateOrCreate')->once();
        $catalogImport = new CatalogImport(['file' => 'test.xslx']);
        $catalogImportService->processImport($catalogImport);
    }

    /**
     * Test process import emit event
     */
    public function testProcessImportQueueEvent()
    {
        $catalogImportService = $this->app->make(CatalogImportService::class);
        $catalogImport = new CatalogImport(['id' => 1]);
        $catalogImportService->processImport($catalogImport);
        Event::assertDispatched(CatalogImportUpdated::class, function ($e) use ($catalogImport) {
            return $e->catalogImport->id === $catalogImport->id;
        });
    }
}
