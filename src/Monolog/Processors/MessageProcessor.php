<?php

namespace Logwatch\LaravelAgent\Monolog\Processors;

class MessageProcessor
{
    public function __invoke(array $record)
    {
        $record['extra']['logwatch']['message'] = $record['message'];

        return $record;
    }
}
