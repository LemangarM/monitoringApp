<?php
namespace Models;

class functions
{
    public static function createJsonFile($data)
    {
        $fp = fopen('./tables/barometerData.json', 'w');
        fwrite($fp, json_encode($data));
        fclose($fp);
        
        return $fp;
    }
}
