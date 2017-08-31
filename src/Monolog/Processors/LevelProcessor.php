<?php

namespace Logwatch\LaravelAgent\Monolog\Processors;

class LevelProcessor
{
    private $levelMappings = [
        100 => 'debug',
        200 => 'info',
        250 => 'notice',
        300 => 'warning',
        400 => 'error',
        500 => 'critical',
        550 => 'alert',
        600 => 'emergency'
    ];

    public function __invoke(array $record)
    {
        $record['extra']['logwatch']['level'] = $this->levelMappings[$record['level']];

        return $record;
    }
}
