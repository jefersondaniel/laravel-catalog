<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Page;

class ProductListPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/';
    }
}
