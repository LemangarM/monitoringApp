<?php

namespace Models\Tables;

use Models\App;

/*
  Author LEMANGAR
 */

class Charts
{

    const ID_GLOBAL = '0999BTVSM';

    public static function getAppNameList()
    {
        return App::getDb()->query('
            SELECT DISTINCT appIdAllStore, appName
            FROM apps_infos
            ', __CLASS__);
    }

    public static function appName($id_global = self::ID_GLOBAL)
    {
        return App::getDb()->prepare("
            SELECT DISTINCT appIdAllStore, appName
            FROM apps_infos
            WHERE appIdAllStore = ?
            ",[$id_global], __CLASS__);
    }

    /*
     * Table infos générales
     */

    public static function InfosAndroid($id_global = self::ID_GLOBAL)
    {
        return App::getDb()->prepare("
            SELECT a.appID, appVersion, appMinimumOsVersion, appTotalStars, Unites_total, Unites_cumul, currentVersionReleaseDate
            FROM appstore a
            LEFT JOIN apps_infos b ON a.appID=b.appID
            LEFT JOIN sales_cumul c ON a.appID=c.appID
            WHERE b.appIdAllStore = ?
                AND a.appID LIKE '%00%'
            ORDER BY c.DateMeasure DESC LIMIT 1
               ", [$id_global], __CLASS__);
    }

    public static function InfosIos($id_global = self::ID_GLOBAL)
    {
        return App::getDb()->prepare("
            SELECT a.appID, appVersion, appMinimumOsVersion, appTotalStars, Unites_total, Unites_cumul, currentVersionReleaseDate
            FROM appstore a
            LEFT JOIN apps_infos b ON a.appID=b.appID
            LEFT JOIN sales_cumul c ON a.appID=c.appID
            WHERE b.appIdAllStore = ?
                AND a.appID NOT LIKE '%00%'
            ORDER BY c.DateMeasure DESC LIMIT 1
               ", [$id_global], __CLASS__);
    }

    /*
     * Install & uninstall & upgrade line chart
     */

    public static function getSalesAndroid($id_global = self::ID_GLOBAL)
    {
        return App::getDb()->prepare("
            SELECT a.appID, DateMeasure, Unites, Daily_uninstall, Daily_upgrade
            FROM appstore_sales a
            LEFT JOIN apps_infos b ON a.appID=b.appID
            WHERE b.appIdAllStore = ?
                AND a.appID LIKE '%00%'
            ORDER BY DateMeasure DESC LIMIT 31
            ", [$id_global], __CLASS__);
    }

    public static function getSalesIos($id_global = self::ID_GLOBAL)
    {
        return App::getDb()->prepare("
            SELECT a.appID, DateMeasure, Unites
            FROM appstore_sales a
            LEFT JOIN apps_infos b ON a.appID=b.appID
            WHERE b.appIdAllStore = ?
                AND a.appID NOT LIKE '%00%'
            ORDER BY DateMeasure DESC LIMIT 31
            ", [$id_global], __CLASS__);
    }

    /*
     * Visitors bar chart
     */

    public static function getVisitorsAndroid($id_global = self::ID_GLOBAL)
    {
        return App::getDb()->prepare("
           SELECT a.appID,Unites, DateMeasure
           FROM appstore_uvisitor a
           LEFT JOIN apps_infos b ON a.appID=b.appID
           WHERE b.appIdAllStore = ?
               AND a.appID LIKE '%00%'
           ORDER BY DateMeasure DESC LIMIT 7
           ", [$id_global], __CLASS__);
    }

    public static function getVisitorsIos($id_global = self::ID_GLOBAL)
    {
        return App::getDb()->prepare("
           SELECT a.appID,Unites, DateMeasure
           FROM appstore_uvisitor a
           LEFT JOIN apps_infos b ON a.appID=b.appID
           WHERE b.appIdAllStore = ?
               AND a.appID NOT LIKE '%00%'
           ORDER BY DateMeasure DESC LIMIT 7
           ", [$id_global], __CLASS__);
    }

    /*
     * Notes line chart
     */

    public static function getNotesAndroid($id_global = self::ID_GLOBAL)
    {
        return App::getDb()->prepare("
            SELECT a.appID, DateMeasure, Daily_Average_Rating, Total_Average_Rating
            FROM apps_ratings a
            LEFT JOIN apps_infos b ON a.appID=b.appID
            WHERE b.appIdAllStore = ?
            and a.appID LIKE '%00%'
            ORDER BY DateMeasure desc limit 12
            ", [$id_global], __CLASS__);
    }

    public static function getNotesIos($id_global = self::ID_GLOBAL)
    {
        return App::getDb()->prepare("
            SELECT a.appID, DateMeasure, Total_Average_Rating
            FROM apps_ratings a
            LEFT JOIN apps_infos b ON a.appID=b.appID
            WHERE b.appIdAllStore = ?
            and a.appID NOT LIKE '%00%'
            ORDER BY DateMeasure desc limit 12
            ", [$id_global], __CLASS__);
    }

}
