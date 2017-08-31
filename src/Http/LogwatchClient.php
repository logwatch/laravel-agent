<?php

namespace Logwatch\LaravelAgent\Http;

use GuzzleHttp\Client as Guzzle;

class LogwatchClient
{
    /**
     * @var Guzzle
     */
    private $guzzle;

    /**
     * @var string
     */
    private $loggingEndpoint;

    /**
     * LogwatchClient constructor.
     *
     * @param Guzzle $guzzle
     */
    public function __construct(Guzzle $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    /**
     * Sets the endpoint to submit logs to.
     *
     * @param $endpoint
     */
    public function setLoggingEndpoint($endpoint)
    {
        $this->loggingEndpoint = $endpoint;
    }

    /**
     * Sends a log payload to Logwatch.
     *
     * @param string $payload
     */
    public function sendLogPayload($payload)
    {
        $this->guzzle->post($this->loggingEndpoint, [
            'body' => $payload
        ]);
    }
}
