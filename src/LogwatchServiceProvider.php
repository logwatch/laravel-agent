<?php

namespace Logwatch\LaravelAgent;

use Monolog\Logger;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Config\Repository;
use Logwatch\LaravelAgent\Http\LogwatchClient;
use Illuminate\Contracts\Foundation\Application;
use Logwatch\LaravelAgent\Monolog\LogwatchHandler;
use Logwatch\LaravelAgent\Monolog\LogwatchFormatter;
use Logwatch\LaravelAgent\Monolog\Processors\TimeProcessor;
use Logwatch\LaravelAgent\Monolog\Processors\TypeProcessor;
use Logwatch\LaravelAgent\Monolog\Processors\LevelProcessor;
use Logwatch\LaravelAgent\Monolog\Processors\RequestProcessor;
use Logwatch\LaravelAgent\Monolog\Processors\MessageProcessor;
use Logwatch\LaravelAgent\Monolog\Processors\ExceptionProcessor;

class LogwatchServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/logwatch.php' => config_path('logwatch.php'),
        ], 'config');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        /** @var Repository $config */
        $config = $this->app->make('config');

        $this->app->bind(LogwatchClient::class, function (Application $app) use ($config) {
            $guzzle = new Client([
                'request.options' => [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $config->get('logwatch.auth_token')
                    ]
                ],
                'timeout' => 1
            ]);

            $client = new LogwatchClient($guzzle);
            $client->setLoggingEndpoint($config->get('logwatch.endpoints.logging'));

            return $client;
        });

        $this->app->configureMonologUsing(function (Logger $monolog) use ($config) {
            $monolog->pushProcessor(new TimeProcessor);
            $monolog->pushProcessor(new TypeProcessor);
            $monolog->pushProcessor(new LevelProcessor);
            $monolog->pushProcessor(new MessageProcessor);
            $monolog->pushProcessor(new ExceptionProcessor);
            $monolog->pushProcessor(new RequestProcessor);

            $handler = new LogwatchHandler(
                $config->get('logwatch.min_level'),
                true,
                $this->app->make(LogwatchClient::class)
            );
            $handler->setFormatter(new LogwatchFormatter);
            $monolog->pushHandler($handler);
        });
    }
}
