<?php
namespace Dialect\Scrive;
use Dialect\Scrive\ScriveServiceProvider;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp()
    {
        parent::setUp();
    }
    protected function getPackageProviders($app)
    {
        return [ScriveServiceProvider::class];
    }


    protected function getEnvironmentSetUp($app)
    {
        // make sure, our .env file is loaded
        $app->useEnvironmentPath(__DIR__.'/..');
        $app->bootstrapWith([LoadEnvironmentVariables::class]);
        parent::getEnvironmentSetUp($app);
        $app['config']->set('scrive', [
            'secret_client_identifier' => env('SCRIVE_CLIENT_IDENTIFIER', null),
            'secret_client_secret' => env('SCRIVE_CLIENT_SECRET', null),
            'secret_token_identifier' => env('SCRIVE_TOKEN_IDENTIFIER', null),
            'secret_token_secret' => env('SCRIVE_TOKEN_SECRET', null),
            'developer_mode' => true
        ]);
    }

    public static function callMethod($obj, $name, array $args) {
        $class = new \ReflectionClass($obj);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method->invokeArgs($obj, $args);
    }
}