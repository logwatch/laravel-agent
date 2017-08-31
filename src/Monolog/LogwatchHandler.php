<?php

namespace Logwatch\LaravelAgent\Monolog;

use Monolog\Logger;
use Illuminate\Http\Request;
use Logwatch\LaravelAgent\Http\LogwatchClient;
use Monolog\Handler\AbstractProcessingHandler;

class LogwatchHandler extends AbstractProcessingHandler
{
    /**
     * @var LogwatchClient
     */
    private $logwatchClient;

    /**
     * LogwatchHandler constructor.
     *
     * @param int $level
     * @param bool $bubble
     * @param LogwatchClient $logwatchClient
     */
    public function __construct($level = Logger::DEBUG, $bubble = true, LogwatchClient $logwatchClient)
    {
        parent::__construct($level, $bubble);

        $this->logwatchClient = $logwatchClient;
    }

    /**
     * Writes the log message to Logwatch.
     *
     * @param array $record
     */
    protected function write(array $record)
    {
        try {
            $this->logwatchClient->sendLogPayload($record['formatted']);
        } catch (\Exception $e) {
            // Ignore any errors.
        }
    }
}
