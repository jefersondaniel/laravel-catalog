<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Tests\Browser\Pages\IndexPage;
use Laravel\Dusk\Browser;

class IndexTest extends DuskTestCase
{
    /**
     * Test if user see the catalog import tip
     *
     * @return void
     */
    public function testShowCatalogTip()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new IndexPage)
                    ->assertSee(__('app.import_catalog_tip'));
        });
    }
}
