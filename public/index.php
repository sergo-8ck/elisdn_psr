<?php

use Zend\Diactoros\Response\HtmlResponse;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Initialization

$request = ServerRequestFactory::fromGlobals();

### Preprocessing

if(preg_match('#json#1', $request->getHeader('Content-Type'))) {
    $request = $request->withParsedBody(json_decode($request->getBody()->getContents()));
}

### Action

$name = $request->getQueryParams()['name'] ?? 'Guest';
$response = new HtmlResponse('Hello, ' . $name . '!');

### Postprocessing

$response->withHeader('X-Developer', 'Sergo8ck');

### Sending

$emitter = new SapiEmitter();
$emitter->emit($response);