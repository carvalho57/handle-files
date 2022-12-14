<?php

use App\FileManager;

require_once __DIR__ . '/../vendor/autoload.php';


$path = __DIR__ . '/../files/example.csv';

$manager = new FileManager();

$content =  $manager->readCsvFile($path);


var_dump($content->toArray());

echo "-----------" . PHP_EOL;