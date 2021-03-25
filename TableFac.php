<?php
require_once "ITable.php";
require_once("ErrorLog.php");

use ErrorLog\ErrorLog as FalseWork;

class TableFac implements ITable
{
    private $tableName;
    private $connection;
    private $falseWork;

    public function __construct($tableName)
    {
        $this->falseWork = FalseWork::getErrorInstance();
        $this->tableName = $tableName;
    }

    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

    public function setDbConnection(PDO $dbConnection)
    {
        $this->connection = $dbConnection;
    }

    public function getAllFaculty(){
        $query = $this->connection->prepare("Select * from " . $this->tableName . " ");
        $query->execute();
        if ($query->rowCount() > 0) {
            $resut = $query->fetchAll(PDO::FETCH_ASSOC);
            return $resut;
        }
    }

    public function getFacultyName($name){
        $name = mb_strtoupper($name);
        $query = $this->connection->prepare("Select * from " . $this->tableName . " WHERE fName=?");
        $query->execute(array($name));
        if ($query->rowCount() > 0) {
            $resut = $query->fetch(PDO::FETCH_ASSOC);
            return $resut;
        }
    }

    public function getFacultyId($id){
        $query = $this->connection->prepare("Select * from " . $this->tableName . " WHERE id=?");
        $query->execute(array($id));
        if ($query->rowCount() > 0) {
            $resut = $query->fetch(PDO::FETCH_ASSOC);
            return $resut;
        }
        else{
            echo "ERROOOOOOOOOOOOOOOOOOOOO";
        }
    }

}