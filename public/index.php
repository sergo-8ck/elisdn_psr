<?php

use Framework\Http\Request;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Initialization

//$request = new Request();
//$request->withQueryParams($_GET);
//$request->withParsedBody($_POST);

// необходим return $this в каждом из методов
$request = (new Request())
    ->withQueryParams($_GET)
    ->withParsedBody($_POST);

### Action

$name = $request->getQueryParams()['name'] ?? 'Guest';
header('X-Developer: Sergo8ck');
echo 'Hello, ' . $name . '!';