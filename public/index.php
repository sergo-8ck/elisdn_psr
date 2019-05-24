<?php

use Test\Framework\Http\RequestFactory;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Initialization

$request = RequestFactory::fromGlobals();

### Action

$name = $request->getQueryParams()['name'] ?? 'Guest';
header('X-Developer: Sergo8ck');
echo 'Hello, ' . $name . '!';