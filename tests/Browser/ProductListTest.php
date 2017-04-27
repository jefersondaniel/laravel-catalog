<?php

namespace Tests\Browser;

use App\Product;
use Tests\DuskTestCase;
use Tests\Browser\Pages\ProductListPage;
use Laravel\Dusk\Browser;

class ProductListTest extends DuskTestCase
{
    /**
     * Test if user see the catalog import tip
     *
     * @return void
     */
    public function testShowAlertIfNoItems()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new ProductListPage)
                    ->assertSee(__('app.import_catalog_tip'));
        });
    }

    /**
     * Test if product list is being rendered
     *
     * @return void
     */
    public function testShowList()
    {
        factory(Product::class)->create(['name' => 'Spoon']);

        $this->browse(function (Browser $browser) {
            $browser->visit(new ProductListPage)
                    ->assertSee('Spoon');
        });
    }
}
