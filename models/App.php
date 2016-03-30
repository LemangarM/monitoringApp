<?php
namespace Models;

include_once 'models/Database.php';

class App
{
    const DB_NAME = 'btelecom';
    const DB_USER = 'root';
    const DB_PASS = '';
    const DB_HOST = 'localhost';
    
    private static $database;
    
    public static function getDb()
    {
        if(self::$database === null)
        {
            self::$database = new Database(self::DB_NAME,  self::DB_USER, self::DB_PASS, self::DB_HOST);                  
        }
        return self::$database;
    }  
}
