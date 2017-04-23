<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Page;
use Tests\Browser\Concerns\UploadFile;

class CatalogImportPage extends Page
{
    use UploadFile;

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/products/import';
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@attachment' => '#file',
        ];
    }
}
