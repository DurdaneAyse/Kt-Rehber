<?php

namespace DesignPattern\AbstractFactory;
require_once("IDatabaseFactory.php");
require_once("DBMySqlConnectSingle.php");

class MysqlFactory implements IDatabaseFactory
{
    public function createDatabaseConect(): IDBConnect
    {
        return DBMySqlConnectSingle::getDbInstance();
    }
}