<?php

use App\FileManager;

require_once __DIR__ . '/../vendor/autoload.php';


$path = __DIR__ . '/../files/example.xml';

$manager = new FileManager();

$content = $manager->readXML($path)->toJson();

var_dump($content);