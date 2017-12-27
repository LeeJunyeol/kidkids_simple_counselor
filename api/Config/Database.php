<?php
namespace KCS\Config;

use \PDO;

class Database {
    private static $host = "localhost";
    private static $dbname = "mydb";
    private static $username = "root";
    private static $password = "";

    static public $conn;
    
    public static function getConnection(){
        if(empty(self::$conn)){
            self::$conn = null;
            try{
                self::$conn = new \PDO("mysql:host=" . self::$host . ";dbname=" . self::$dbname, self::$username, self::$password);
                self::$conn->exec("set names utf8");
            }catch(PDOException $exception){
                echo "Connection error: " . $exception->getMessage();
            }
        }
        return self::$conn;
    }
}
?>