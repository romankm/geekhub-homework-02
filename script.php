<?php

require 'vendor/autoload.php';

use Carbon\Carbon;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('Test log');
$log->pushHandler(new StreamHandler('test.log', Logger::WARNING));
$log->addRecord(Logger::INFO, 'Hello world');

printf("Now: %s", Carbon::now());
