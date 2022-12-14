<?php

namespace App;

use App\Exception\FileNotFoundException;

class FileManager {

    private array $values = array();

    /**
     * @throws FileNotFoundException
     * @throws \Exception
     */
    public function readCsvFile(string $fileLocation, string $separator = ',') {

        //File Exist
        if( !file_exists($fileLocation))
            throw new FileNotFoundException();

        if( !is_file($fileLocation) && !is_readable($fileLocation)) 
            throw new \Exception("Is not a file or is not readable");

        $handler = fopen($fileLocation,'r');

        if($handler === false)
            throw new \Exception("Cannot open file: " . $fileLocation);
        
        $header = fgetcsv($handler,1000,$separator);
        
        while (($line = fgetcsv($handler,1000,$separator)) !== false) {                                 
            $item = array();
            foreach($line as $key => $value) {
                $item[$header[$key]] = $value;
            }
            $this->values[] = $item;
        }

        fclose($handler);

        return $this;
    }    

    public function toJson() {
        return json_encode($this->values);
    }

    public function toArray() {
        return $this->values;
    }
    
}