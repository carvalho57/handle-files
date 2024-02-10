<?php

use App\FileManager;
use App\FileStore;

require_once __DIR__ . '/../vendor/autoload.php';


$path = __DIR__ . '/../files/example.csv';

$manager = new FileManager();

$data = $manager->readCsvFile($path);

var_dump($data);


// $storage = new FileStore(dirname($path),basename($path));

// $storage->save("1 - Database|OlaMundo|Teste|Bananda". PHP_EOL);
// $storage->save("2 - Database|OlaMundo|Teste|Bananda". PHP_EOL);
// $storage->save("3 - Database|OlaMundo|Teste|Bananda". PHP_EOL);
// $storage->save("4 - Database|OlaMundo|Teste|Bananda". PHP_EOL);


// $storage->update("4 - Banco|Ola Mundo|Testudo|Banana", 4);