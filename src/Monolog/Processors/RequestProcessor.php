<?php

namespace Logwatch\LaravelAgent\Monolog\Processors;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Container\Container;

class RequestProcessor
{
    /**
     * @var Request
     */
    private $request;

    public function __invoke(array $record)
    {
        $this->setRequest();

        if ($this->request === null) {
            // Application is not running in the context of a HTTP request.
            $record['extra']['logwatch']['request'] = null;

            return $record;
        }

        $record['extra']['logwatch']['request'] = [
            'url' => $this->url(),
            'method' => $this->method(),
            'query_strings' => $this->queryStrings(),
            'body_fields' => $this->bodyFields(),
            'files' => $this->files(),
            'client_ip' => $this->clientIp()
        ];

        return $record;
    }

    private function setRequest()
    {
        $app = Container::getInstance();

        $this->request = $app['request'];
    }

    private function url()
    {
        return $this->request->url();
    }

    public function method()
    {
        return strtolower($this->request->method());
    }

    private function queryStrings()
    {
        $queryStrings = [];

        foreach ($this->request->query() as $key => $value) {
            $queryStrings[] = [
                'key' => $key,
                'value' => $value
            ];
        }

        return $queryStrings;
    }

    private function bodyFields()
    {
        $bodyFields = [];

        $contentType = $this->request->header('content-type');

        if ($contentType === 'application/json' || $contentType === 'application/x-www-form-urlencoded') {
            $fields = $this->request->post();
        } else {
            $fields = $_POST;
        }

        foreach ($fields as $key => $value) {
            $bodyFields[] = [
                'key' => $key,
                'value' => $value
            ];
        }

        return $bodyFields;
    }

    private function files()
    {
        $files = [];

        /** @var UploadedFile $file */
        foreach ($this->request->allFiles() as $file) {
            $files[] = [
                'name' => $file->getClientOriginalName(),
                'mimeType' => $file->getClientMimeType(),
                'size' => $file->getSize()
            ];
        }

        return $files;
    }

    private function clientIp()
    {
        return $this->request->getClientIp();
    }
}
