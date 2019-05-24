<?php

namespace Framework\Http;

class Request
{
    private $queryParams;
    private $parsedBody;

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function withQueryParams(array $query)
    {
        $this->queryParams = $query;
        return $this;
    }

    public function getParsedBody()
    {
        return $this->parsedBody ?: null;
    }

    public function withParsedBody($data)
    {
        $this->parsedBody = $data;
        return $this;
    }

}