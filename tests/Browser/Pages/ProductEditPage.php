<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Page;

class ProductEditPage extends Page
{
    /**
     * @var integer
     */
    private $id;

    /**
     * Creates a page
     *
     * @param integer $id
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/products/' . $this->id . '/edit';
    }
}
