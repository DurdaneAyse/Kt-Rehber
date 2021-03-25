<?php
namespace DesignPattern\AbstractFactory;
date_default_timezone_set('Turkey');
require_once ("ErrorLog.php");
require_once ("IDBConnect.php");
use ErrorLog\ErrorLog as FalseWork;
class DBMySqlConnectSingle implements IDBConnect
{
    private static $dbInstance = null;
    private $dbConnect = null;
    private $falseWork = null;
    private function __construct()
    {
        $this->falseWork = FalseWork::getErrorInstance();
    }

    public static function getDbInstance()
    {
        if (static::$dbInstance == null)
            static::$dbInstance = new DBMySqlConnectSingle();
        return static::$dbInstance;
    }

    public static function closeDbInstance()
    {
        if (static::$dbInstance != null)
            static::$dbInstance = null;
    }

    public function getDbConnect()
    {
        if ($this->dbConnect != null)
            return $this->dbConnect;

    }

    public function connectDbInstance(){
        try {
            $this->dbConnect = new \PDO("mysql:host=localhost;dbname=dbminerva;charset=UTF8", "root", "");
        } catch (\PDOException $error) {
            $this->falseWork->writeError("Veri Tabanı Bağlantısı Başarısız");
        }
    }
}