<?php

namespace Logwatch\LaravelAgent\Monolog\Processors;

class ExceptionProcessor
{
    public function __invoke(array $record)
    {
        if (! isset($record['context']['exception'])) {
            $record['extra']['logwatch']['exception'] = null;

            return $record;
        }

        /** @var \Exception $exception */
        $exception = $record['context']['exception'];

        $record['extra']['logwatch']['exception'] = [
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace_string' => $exception->getTraceAsString()
        ];

        return $record;
    }
}
