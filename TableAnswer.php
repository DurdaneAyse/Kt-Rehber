<?php
require_once "ITable.php";
require_once("ErrorLog.php");

use ErrorLog\ErrorLog as FalseWork;

class TableAnswer implements ITable
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

    public function addAnswer($answer, $answererid,$questionid,$userType)
    {
        $time = date('d.m.Y H.i.s', time());
        $query = $this->connection->query("INSERT INTO  " . $this->tableName . " (answererid,questionid,answer,time,userType) values ('$answererid','$questionid','$answer','$time','$userType')");
        if ($this->queryError($query, "Answer ekleme Hatası")) {
            return false;
        }
        return true;
    }

    public function getAllQuestionAnswer($questionid)
    {
        $query = $this->connection->prepare("Select * from " . $this->tableName . " WHERE questionid=?");
        $query->execute(array($questionid));
        if ($query->rowCount() > 0) {
            $resut = $query->fetchAll(PDO::FETCH_ASSOC);
            return $resut;
        }
    }
    private function queryError($query, $message)
    {
        if (!$query) {
            $this->falseWork->writeError($message);
            return true;
        }
    }
}