<?php

namespace App\Services;

use App\CatalogImport;
use App\Product;
use App\Events\CatalogImportUpdated;
use App\Repositories\ProductRepository;
use App\Repositories\CatalogImportRepository;
use App\Jobs\ProcessCatalogImport;
use Illuminate\Support\Facades\Storage;
use PHPExcel_IOFactory;

class CatalogImportService
{
    /**
     * @var SpreadsheetReaderService
     */
    private $spreadsheetReaderService;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var CatalogImportRepository
     */
    private $catalogImportRepository;

    /**
     * Constructs the service
     *
     * @param SpreadsheetReaderService $spreadsheetReaderService
     * @return void
     */
    public function __construct(
        SpreadsheetReaderService $spreadsheetReaderService,
        ProductRepository $productRepository,
        CatalogImportRepository $catalogImportRepository
    ) {
        $this->spreadsheetReaderService = $spreadsheetReaderService;
        $this->productRepository = $productRepository;
        $this->catalogImportRepository = $catalogImportRepository;
    }

    /**
     * Starts a catalog import
     *
     * @param CatalogImport $catalogImport
     * @return void
     */
    public function create(CatalogImport $catalogImport)
    {
        $this->catalogImportRepository->save($catalogImport);
        dispatch(new ProcessCatalogImport($catalogImport));
    }

    /**
     * Process catalog import
     *
     * @param CatalogImport $catalogImport
     * @return void
     */
    public function  processImport(CatalogImport $catalogImport)
    {
        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $attachmentPath = $storagePath . '/' . $catalogImport->attachment;
        $rows = $this->spreadsheetReaderService->readRows(
            $attachmentPath,
            ['lm', 'name', 'category', 'free_shipping', 'description', 'price']
        );
        $success = 0;
        foreach ($rows as $row) {
            $product = new Product;
            $product->fill($row);
            $this->productRepository->updateOrCreate($product);
            $success = 1;
        }
        if (! $success) {
            $this->handleError($catalogImport);
        }
        $this->markAsCompleted($catalogImport);
    }

    /**
     * Update import information about the error
     *
     * @param $catalogImport
     * @return void
     */
    protected function handleError(CatalogImport $catalogImport)
    {
        $catalogImport->error_message = __('app.import_catalog_failed');
    }

    /**
     * Mark a import as completed
     *
     * @param $catalogImport
     * @return void
     */
    protected function markAsCompleted(CatalogImport $catalogImport)
    {
        $catalogImport->completed = true;
        $this->catalogImportRepository->save($catalogImport);
        event(new CatalogImportUpdated($catalogImport));
    }
}
