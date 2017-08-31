<?php

namespace Logwatch\LaravelAgent\Monolog\Processors;

class TimeProcessor
{
    public function __invoke(array $record)
    {
        $record['extra']['logwatch']['time'] = $record['datetime']->format(DATE_ATOM);

        return $record;
    }
}
