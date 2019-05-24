<?php

namespace Framework\Http;

class Request
{
    private $queryParams;
    private $parsedBody;

    public function __construct(array $queryParams = [], $paresdBody = null)
    {
        $this->queryParams = $queryParams;
        $this->parsedBody = $paresdBody;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function getParsedBody()
    {
        return $this->parsedBody ?: null;
    }
}