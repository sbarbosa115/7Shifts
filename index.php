<?php

use CodeTests\Shifts\Utils\Calculator;

require __DIR__ . '/vendor/autoload.php';

$input = null;

$input = $_GET['q'] ?? $argv[1];

if (!$input) {
    throw new InvalidArgumentException('Argument is required');
}

$calculator = new Calculator();

var_dump($calculator->add($input));
