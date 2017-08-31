<?php

namespace Logwatch\LaravelAgent\Monolog\Processors;

class TypeProcessor
{
    public function __invoke(array $record)
    {
        if (isset($record['context']['exception'])) {
            $record['extra']['logwatch']['type'] = 'exception';
        } else {
            $record['extra']['logwatch']['type'] = 'log';
        }

        return $record;
    }
}
