<?php

namespace Tests\Browser;

use App\Product;
use Tests\DuskTestCase;
use Tests\Browser\Pages\ProductEditPage;
use Faker\Generator;
use Laravel\Dusk\Browser;

class ProductEditTest extends DuskTestCase
{
    /**
     * Test if product edit success
     *
     * @return void
     */
    public function testEditSuccess()
    {
        factory(Product::class)->create(
            ['id' => 444, 'lm' => 122, 'name' => 'Actual name']
        );

        $this->browse(function (Browser $browser) {
            $browser->visit(new ProductEditPage(444))
                ->type('name', 'Expected name')
                ->type('category', 'Test')
                ->check('free_shipping')
                ->type('description', 'Test')
                ->type('price', '2')
                ->press('Edit')
                ->assertPathIs('/')
                ->assertSee('Expected name');
        });
    }

    /**
     * Test if product edit fail
     *
     * @return void
     */
    public function testEditFail()
    {
        factory(Product::class)->create(
            ['id' => 444, 'lm' => 122, 'name' => 'Actual name']
        );

        $this->browse(function (Browser $browser) {
            $browser->visit(new ProductEditPage(444))
                ->type('name', '')
                ->press('Edit')
                ->assertSee('name must be a string');
        });
    }
}
