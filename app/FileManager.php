<?php

namespace App;

use App\Exception\CannotAcessFileException;
use InvalidArgumentException;

class FileManager {

    private $values;    
    
    public function readCsvFile(string $fileLocation, string $separator = ',') {
        
        if(!$this->canHandleFile($fileLocation))
            throw new CannotAcessFileException();

        $extension = pathinfo($fileLocation,PATHINFO_EXTENSION);

        if($extension !== 'csv')
            throw new InvalidArgumentException('Is not a valid CSV file');

        $handler = fopen($fileLocation,'r');

        if($handler === false)
            throw new \Exception("Cannot open file: " . $fileLocation);
        
        $header = fgetcsv($handler,1000,$separator);
        
        while (($line = fgetcsv($handler,1000,$separator)) !== false) {                                             
            $this->values[] = array_combine($header,$line);
        }

        fclose($handler);

        return $this;
    }    

    public function readXML(string $fileLocation) {
        if(!$this->canHandleFile($fileLocation))
            throw new CannotAcessFileException();

        $extension = pathinfo($fileLocation,PATHINFO_EXTENSION);

        if($extension !== 'xml')
            throw new InvalidArgumentException('Is not a valid XML file');

        $content = file_get_contents($fileLocation);

        if($content === false)
            throw new \Exception("Cannot open file: " . $fileLocation);

        $xml = simplexml_load_string($content);
        $this->values = json_decode(json_encode($xml),true);
        return $this;
    }

    private function canHandleFile(string $path) {        
        if( !file_exists($path)) {
            echo "File does not exist: " . $path;
            return false;
        }

        if( !is_file($path) && !is_readable($path))  {
            echo "Is not a file";
            return false;
        }

        return true;
    }


    public function toJson() {
        return json_encode($this->values);
    }

    public function toArray() {
        return $this->values;
    }
    
}