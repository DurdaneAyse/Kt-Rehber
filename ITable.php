<?php

interface ITable
{
    public function setTableName($tableName);
    public function setDbConnection(PDO $dbConnection);
}