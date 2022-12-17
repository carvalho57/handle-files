<?php

namespace App;

use InvalidArgumentException;

class FileStore {        
    private string $fullPath = '';   
    private int $offset = 0; 

    public function __construct(private string $path, private string $filename)
    {                
        if(!is_dir($path))  throw new InvalidArgumentException("Invalid Path");        

        $this->fullPath = "{$path}/{$filename}";         
        
        if(!file_exists($this->fullPath)) {            
            touch($this->fullPath);
        }
    }

    /**
     * @throws \Exception
     */
    public function save(string $content): void
    {

        if(($handler = fopen($this->fullPath,'a')) === false) {
            throw new \Exception("Cannot open the file");
        }
        
        if(fputs($handler,$content) === false) {
            throw new \Exception("Cannot write to the file");
        }

        fclose($handler);
    }

    /**
     * @throws \Exception
     */
    public function read() {
        if(($handler = fopen($this->fullPath,'r')) === false) {
            throw new \Exception("Cannot open the file");
        }
        
        $content = array();
        while(($line = fgets($handler)) !== false) {
            $content[] = $line;
        }

        fclose($handler);
        return $content;
    }

    /**
     * @throws \Exception
     */
    public function readLine(int $lineNumber = 1) {
        if(($handler = fopen($this->fullPath,'r')) === false) {
            throw new \Exception("Cannot open the file");
        }
        
        $this->jumpToLine($handler, $lineNumber);

        $content = fgets($handler);

        fclose($handler);
        return $content;
    }

    public function update($content, $lineNumber) {                

        if(($handler = fopen($this->fullPath,'r+')) === false) {
            throw new \Exception("Cannot open the file");
        }
            
        $this->jumpToLine($handler, $lineNumber - 1);
        
        $lineBytes = strlen(fgets($handler));
        $contentLength = strlen($content);              
        
        $length = $lineBytes > $contentLength ? $lineBytes : $contentLength;

        if($content[$contentLength - 1] != PHP_EOL) {
            $content .= PHP_EOL;
        }

        fwrite($handler, str_pad($content, $length));
    }
    

    public function jumpToLine($handler, $lineNumber) {

        $count = 0;
        $lineNumber--;    
        
        while(($line = fgets($handler)) !== false) {
            $this->offset += strlen($line);
            if(($count + 1) == $lineNumber) {
                return $handler;                
            }
            $count++;
        }            
                    
        return false;        
    }

       
}