<?php

use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;

abstract class BrowserKitTestCase extends Laravel\BrowserKitTesting\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    protected function actingAsUser()
    {
        $user = factory(App\User::class)->create();

        $this->actingAs($user);

        return $user;
    }

    // Use this version if you're on PHP 7
    protected function withoutExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct()
            {
            }

            public function report(Exception $e)
            {
                // no-op
            }

            public function render($request, Exception $e)
            {
                throw $e;
            }
        });
    }

    protected function usingTestDisplayTimeZone($timezone = null)
    {
        Config::set('app.display_timezone', $timezone ?? 'Australia/Sydney');
    }
}
