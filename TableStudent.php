<?php

require_once("ITable.php");
require_once("ErrorLog.php");
require_once("Mailler.php");
//require_once ("PythonMailler.php");
use ErrorLog\ErrorLog as FalseWork;

class TableStudent implements ITable
{
    private $tableName;
    private $connection = null;
    private $falseWork = null;
    private $sendMail = null;

    public function __construct($tableName)
    {
        $this->falseWork = FalseWork::getErrorInstance();
        $this->tableName = $tableName;
        $this->sendMail = new Mailler();
    }

    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

    public function setDbConnection(PDO $dbConnection)
    {
        $this->connection = $dbConnection;
    }

    public function addNewStudent($s_email, $s_password)
    {
        if (strpos($s_email, "@ogr.ktu.edu.tr") !== false ){
            $time = date('d.m.Y H.i.s', time());
            $activationcode = md5(rand(0, 99) . $s_email);
            $s_password = md5($s_password);
            $t_Activation = 1;
            $query = $this->connection->query("INSERT INTO " . $this->tableName . " (Semail,Spassword,time,activationcode,activation) values ('$s_email','$s_password','$time','$activationcode','$t_Activation')");
            if ($this->queryError($query, "AddNewStudent Query Hatası"))
                return "kayitNo";
            if ($this->sendActivationMail($s_email, $activationcode))
                return "kayitOk";
            return "kayitNo";
        }else{
            return "ögrenci emaili degil";
        }

    }
    public function controlStudent($s_email){
        $query = $this->connection->prepare("Select * from " . $this->tableName . " WHERE Semail=?");
        $query->execute(array($s_email));
        return $query->rowCount();
    }

    public function deleteStudent(int $id)
    {
        $query = $this->connection->query("DELETE FROM " . $this->tableName . " WHERE id='$id'");
        if ($this->queryError($query, "DeleteStudent Query Hatası"))
            return false;
        return true;
    }

    public function updateStudent($id, $s_email,$sifre,$facultyıd)
    {
        $query = $this->connection->query("UPDATE " . $this->tableName . " SET Semail='$s_email',Spassword='$sifre',facultyId='$facultyıd' WHERE id='$id'");
        if ($this->queryError($query, "UpdateStudent Query Hatası"))
            return false;
        return true;
    }

    private function queryError($query, $message)
    {
        if (!$query) {
            $this->falseWork->writeError($message);
            return true;
        }
    }

    private function sendActivationMail($email, $activationCode)
    {
        /*
        $activationLink = '"localhost/minerva/activation.php?code='.$activationCode.'&usrmode=student"';
        $pythonMailler = new PythonMailler($email,$activationLink);
        if ($pythonMailler == "true"){
            header('Location:index.php');
        }else{
            return false;
        }*/
        return true;
    }

    public function loginActivateStudent($activationCode)
    {
        
        $query = $this->connection->query("UPDATE " . $this->tableName . " SET activation=1 WHERE activationcode='$activationCode'");
        if ($this->queryError($query, "LoginActivationStudent Query Hatası"))
            return false;
        return true;

    }

    public function getStudent(int $id)
    {
        $query = $this->connection->prepare("Select * from " . $this->tableName . " WHERE id=?");
        $query->execute(array($id));
        if ($query->rowCount() > 0) {
            $resut = $query->fetch(PDO::FETCH_ASSOC);
            return $resut;
        }

    }
    public function getStudenEmail($email){
        $query = $this->connection->prepare("Select * from " . $this->tableName . " WHERE Semail=?");
        $query->execute(array($email));
        if ($query->rowCount() > 0) {
            $resut = $query->fetch(PDO::FETCH_ASSOC);
            return $resut;
        }
    }
    public function getAllStudent()
    {
        $query = $this->connection->prepare("Select * from " . $this->tableName . " ");
        $query->execute();
        if ($query->rowCount() > 0) {
            $resut = $query->fetchAll(PDO::FETCH_ASSOC);
            return $resut;
        }

    }
    public function loginStudent($email,$password){
        $password = md5($password);
        $query = $this->connection->prepare("Select * from " . $this->tableName . " WHERE Semail =? AND Spassword=? ");
        $query->execute(array($email,$password));
        if ($query->rowCount() > 0){
            $query2 = $this->connection->prepare("Select * from " . $this->tableName . " WHERE Semail =? AND activation=? ");
            $query2->execute(array($email,1));
            if ($query2->rowCount() > 0){
                $result = $query2->fetch(PDO::FETCH_ASSOC);
                return $result;
            }else{
                return "Hesap Aktif Değil";
            }

        }else{
            return false;
        }
    }
}