<?php
require_once("ITable.php");
require_once("ErrorLog.php");
require_once("Mailler.php");

use ErrorLog\ErrorLog as FalseWork;

class TableAnon implements ITable
{
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
    public function addNewAnon($s_email, $s_password)
    {
        $time = date('d.m.Y H.i.s', time());
        $activationcode = md5(rand(0, 99) . $s_email);
        $s_password = md5($s_password);
        $query = $this->connection->query("INSERT INTO " . $this->tableName . " (Aemail,Apassword,time,activationcode) values ('$s_email','$s_password','$time','$activationcode')");
        if ($this->queryError($query, "AddNewAnon Query Hatası"))
            return false;
        if ($this->sendActivationMail($s_email, $activationcode))
            return true;
        return false;
    }

    public function deleteAnon(int $id)
    {
        $query = $this->connection->query("DELETE FROM " . $this->tableName . " WHERE id='$id'");
        if ($this->queryError($query, "DeleteAnon Query Hatası"))
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
        if ($this->sendMail->sendActivationMail($email, $activationCode, "anon"))
            return true;
        $this->falseWork->writeError("Aktivasyon Maili Gönderilemedi");
        return false;
    }

    public function loginActivateAnon($activationCode)
    {
        $query = $this->connection->query("UPDATE " . $this->tableName . " SET activation=1 WHERE activationcode='$activationCode'");
        if ($this->queryError($query, "LoginActivationAnon Query Hatası"))
            return false;
        return true;
    }
    public function getAnon(int $id)
    {
        $query = $this->connection->prepare("Select * from " . $this->tableName . " WHERE id=?");
        $query->execute(array($id));
        if ($query->rowCount() > 0) {
            $resut = $query->fetch(PDO::FETCH_ASSOC);
            return $resut;
        }
    }
    public function getAnonEmail($email)
    {
        $query = $this->connection->prepare("Select * from " . $this->tableName . " WHERE Aemail=?");
        $query->execute(array($email));
        if ($query->rowCount() > 0) {
            $resut = $query->fetch(PDO::FETCH_ASSOC);
            return $resut;
        }

    }
    public function updateAnon($id, $s_email,$sifre)
    {   $sifreMd = md5($sifre);
        $query = $this->connection->query("UPDATE " . $this->tableName . " SET Aemail='$s_email',Apassword='$sifreMd' WHERE id='$id'");
        if ($this->queryError($query, "UpdateStudent Query Hatası"))
            return false;
        return true;
    }
    public function controlAnon($s_email){
        $query = $this->connection->prepare("Select * from " . $this->tableName . " WHERE Aemail=?");
        $query->execute(array($s_email));
        return $query->rowCount();
    }
    public function getAllAnon()
    {
        $query = $this->connection->prepare("Select * from " . $this->tableName . " ");
        $query->execute();
        if ($query->rowCount() > 0) {
            $resut = $query->fetchAll(PDO::FETCH_ASSOC);
            return $resut;
        }

    }
    public function loginAnon($email,$password){
        $password = md5($password);
        $query = $this->connection->prepare("Select * from " . $this->tableName . " WHERE Aemail =? AND Apassword=? ");
        $query->execute(array($email,$password));
        if ($query->rowCount() > 0){
            $query2 = $this->connection->prepare("Select * from " . $this->tableName . " WHERE Aemail =? AND activation=? ");
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