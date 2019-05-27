<?php

namespace Test\Framework\Http;

use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequest;

class RequestTest extends TestCase
{
    public function testEmpty(): void
    {
        $request = new ServerRequest();

        self::assertEquals([], $request->getQueryParams());
        self::assertNull($request->getParsedBody());
    }

    public function testQueryParams(): void
    {
        $request = (new ServerRequest())
            ->withQueryParams($data = [
                'name' => 'John',
                'age' => 20
            ]);

        self::assertEquals($data, $request->getQueryParams());
        self::assertNull($request->getParsedBody());
    }

    public function testParseBody(): void
    {
        $request = (new ServerRequest())
            ->withParsedBody($data = ['title' => 'Title']);

        self::assertEquals([], $request->getQueryParams());
        self::assertEquals($data, $request->getParsedBody());
    }
}