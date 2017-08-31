<?php

namespace Logwatch\LaravelAgent\Monolog;

use Monolog\Formatter\JsonFormatter;

class LogwatchFormatter extends JsonFormatter
{
    public function format(array $record)
    {
        return parent::format($record['extra']['logwatch']);
    }
}
