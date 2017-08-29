<?php

namespace Tests;

use Laravel\Dusk\TestCase as BaseTestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

/**
 * TODO: config dusk and make it work using $browser->loginAs($user->id)
 * References: https://laravel.com/docs/5.4/dusk#authentication
 * References: https://medium.com/@splatEric/working-with-laravel-dusk-54d67cc0241b
 * @var [type]
 */
abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication, ModelHelper;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        static::startChromeDriver();
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        return RemoteWebDriver::create(
            'http://localhost:9515', DesiredCapabilities::chrome()
        );
    }
}
