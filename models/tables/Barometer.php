<?php
namespace Models\Tables;

use Models\App;

class Barometer
{
    
    public static function getBarometer()
    {
        return App::getDb()->query('
            SELECT appstore.appID, appName, DateMeasure, appTotalStars, image, store, sales_cumul.appID, Unites_cumul, Unites_total 
            FROM sales_cumul 
            LEFT JOIN appstore 
                ON (appstore.appID=sales_cumul.appID) 
            WHERE DateMeasure= (SELECT Max(DateMeasure) FROM sales_cumul) 
            AND sales_cumul.appID 
            ORDER BY appTotalStars DESC
            ',__CLASS__);
    }
    
    public static function getIosBarometer()
    {
        return App::getDb()->query('
            SELECT appstore.appID, appName, DateMeasure, appTotalStars, image, store, sales_cumul.appID, Unites_cumul, Unites_total 
            FROM sales_cumul 
            LEFT JOIN appstore 
                ON (appstore.appID=sales_cumul.appID) 
            WHERE DateMeasure= (SELECT Max(DateMeasure) FROM sales_cumul) 
            AND sales_cumul.appID 
            NOT LIKE "00%"
            ',__CLASS__);
        
    }
    
    public static function getAndroidBarometer()
    {
        return App::getDb()->query('
            SELECT appstore.appID, appName, DateMeasure, DateMeasureTaken, appTotalStars, image, store, sales_cumul.appID, Unites_cumul, Unites_total 
            FROM sales_cumul 
            LEFT JOIN appstore 
                ON (appstore.appID=sales_cumul.appID) 
            WHERE DateMeasure = (SELECT Max(DateMeasure) FROM sales_cumul) 
            AND sales_cumul.appID 
            LIKE "00%"
            ',__CLASS__);       
    }
}
