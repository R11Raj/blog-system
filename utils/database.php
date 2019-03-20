<?php
/**
 * Created by PhpStorm.
 * User: Raj
 * Date: 15-03-2019
 * Time: 12:16
 */
 require_once __DIR__.'/../config/dbcredentials.php';

class DatabaseUtils {

    private static $connection = null;

    static function get_connection()
    {
        if (self::$connection==null) {
            try {
                // Open connection, ensure exceptions are displayed
                $connection = new PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection = $connection;
            }
            catch(PDOException $e)
            {
                echo "Connection failed: " . $e->getMessage();
                throw new Exception('Application initialization failed');
            }
        }
        return self::$connection;
    }

}
?>