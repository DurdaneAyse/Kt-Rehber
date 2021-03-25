<?php
require_once "ITable.php";
require_once("ErrorLog.php");

use ErrorLog\ErrorLog as FalseWork;

class TableQuestion implements ITable
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

    public function addQuestion($question,$questionerid,$faculty,$userType,$message){
        $time = date('d.m.Y H.i.s', time());
        $query = $this->connection->query("INSERT INTO  ".$this->tableName." (questionerid,question,time,faculty,userType,qmsg) values ('$questionerid','$question','$time','$faculty','$userType','$message')");
        if ($this->queryError($query,"Question ekleme Hatası")){
            return false;
        }
        return true;
    }
    public function getLastId(){
        $query = $this->connection->prepare("Select * from " . $this->tableName . " ORDER BY id DESC LIMIT 1");
        $query->execute();
        $resut = $query->fetch(PDO::FETCH_ASSOC);
        $lastId = $resut["id"];
        return $lastId;
    }
    public function getQuestionsFaculty($faculty){
        $query = $this->connection->prepare("Select * from " . $this->tableName . " WHERE faculty=? ORDER BY id desc");
        $query->execute(array($faculty));
        if ($query->rowCount() > 0) {
            $resut = $query->fetchAll(PDO::FETCH_ASSOC);
            return $resut;
        }
    }
    public function getQuestionsFacultyLastSix($faculty){
        $query = $this->connection->prepare("Select * from " . $this->tableName . " WHERE faculty=? ORDER BY id desc LIMIT 6 ");
        $query->execute(array($faculty));
        if ($query->rowCount() > 0) {
            $resut = $query->fetchAll(PDO::FETCH_ASSOC);
            return $resut;
        }
    }
    public function getQuestionsAllFaculty(){
        $query = $this->connection->prepare("Select * from " . $this->tableName . " ORDER BY id desc");
        $query->execute();
        if ($query->rowCount() > 0) {
            $resut = $query->fetchAll(PDO::FETCH_ASSOC);
            return $resut;
        }
    }
    public function getQuestionId($id){
        $query = $this->connection->prepare("Select * from " . $this->tableName . " WHERE id=?");
        $query->execute(array($id));
        if ($query->rowCount() > 0) {
            $resut = $query->fetch(PDO::FETCH_ASSOC);
            return $resut;
        }
    }
    public function getMessageFaculty($message){
        $messageTEmp = "%".$message."%";
        $query = $this->connection->prepare("Select * from " . $this->tableName . " WHERE question like ?");
        $query->execute(array($messageTEmp));
        if ($query->rowCount() > 0) {
            $resut = $query->fetchAll(PDO::FETCH_ASSOC);
            return $resut;
        }
    }
    public function getMessageIdFaculty($id,$message){
        $messageTEmp = "%".$message."%";
        $query = $this->connection->prepare("Select * from " . $this->tableName . " WHERE id=? AND question like ?");
        $query->execute(array($id,$messageTEmp));
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