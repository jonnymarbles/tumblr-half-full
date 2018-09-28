<?php

define ('BASE_DIR', __DIR__ . '/..');

$loader = require "./../vendor/autoload.php";
$loader->add('tests\\', BASE_DIR);
