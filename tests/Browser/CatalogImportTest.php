<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Tests\Browser\Pages\CatalogImportPage;
use Laravel\Dusk\Browser;

class CatalogImportTest extends DuskTestCase
{
    /**
     * Test if only spreadsheet files are accepted
     *
     * @return void
     */
    public function testRejectNonSpreadsheetFiles()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new CatalogImportPage)
                ->uploadFile('@attachment', __DIR__ . '/files/invalid_file.xsl')
                ->press('Submit')
                ->assertSee('must be a spreadsheet file');
        });
    }

    /**
     * Start processing valid files
     *
     * @return void
     */
    public function testProcessValidFiles()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new CatalogImportPage)
                ->uploadFile('@attachment', __DIR__ . '/files/products.xlsx')
                ->press('Submit')
                ->assertSee('Processing');
        });
    }
}
