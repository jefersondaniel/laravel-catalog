<?php

namespace Tests\Browser\Concerns;

use Laravel\Dusk\Browser;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Remote\UselessFileDetector;

/**
 * Handle file uploads in a way compatible with phantomjs
 *
 * @see https://github.com/Codeception/Codeception/issues/1823
 */
trait UploadFile
{
    /**
     * Upload localfile file using element selector
     *
     * @param Browser $browser
     * @param string $selector Element selector
     * @param string $path File path to upload
     * @return void
     */
    public function uploadFile(Browser $browser, $selector, $path)
    {
        $shortcuts = $this->elements();
        if (isset($shortcuts[$selector])) {
            $selector = $shortcuts[$selector];
        }
        $element = $browser->driver->findElement(WebDriverBy::cssSelector($selector));
        $element->setFileDetector(new UselessFileDetector());
        $element->sendKeys($path);
    }
}
