<?php

namespace App\Jobs;

use App\CatalogImport;
use App\Services\CatalogImportService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessCatalogImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var CatalogImport
     */
    protected $catalogImport;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(CatalogImport $catalogImport)
    {
        $this->catalogImport = $catalogImport;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(CatalogImportService $catalogImportService)
    {
        $catalogImportService->processImport($this->catalogImport);
    }
}
