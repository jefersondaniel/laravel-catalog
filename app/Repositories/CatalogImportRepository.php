<?php

namespace App\Repositories;

use App\CatalogImport;

class CatalogImportRepository
{
    /**
     * Save a catalog import
     *
     * @param CatalogImport $catalogImport
     * @return void
     */
    public function save(CatalogImport $catalogImport)
    {
        $catalogImport->save();
    }
}
