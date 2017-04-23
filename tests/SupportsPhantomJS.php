<?php

namespace Tests;

use Symfony\Component\Process\Process;

/**
 * Provides support to PhantomJS testing
 */
trait SupportsPhantomJS
{
    /**
     * PhantomJS process
     *
     * @var Process
     */
    protected static $phantomProcess;

    /**
     * Start the PhantomJS process
     *
     * @return void
     */
    public static function startPhantomJS()
    {
        static::$phantomProcess = new Process('phantomjs --webdriver=127.0.0.1:9515');
        static::$phantomProcess->start();
        sleep(2);
        static::afterClass(function () {
            static::stopPhantomJS();
        });
    }

    /**
     * Stop the PhantomJS process
     *
     * @return void
     */
    public static function stopPhantomJS()
    {
        if (static::$phantomProcess) {
            static::$phantomProcess->stop();
        }
    }
}
