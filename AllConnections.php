<?php
require_once("ConnectionFactory.php");
require_once("MysqlFactory.php");
require_once("TableStudent.php");
require_once ("TableAnon.php");
require_once ("TableFac.php");
require_once ("TableQuestion.php");
require_once ("TableAnswer.php");
use DesignPattern\AbstractFactory\ConnectionFactory;
use DesignPattern\AbstractFactory\MysqlFactory;
$connectionInstance = new ConnectionFactory(new MysqlFactory());
$connectionInstance->dbConnect();
$tableStudent = new TableStudent("tablestudent");
$connection = $connectionInstance->getIdbConnection()->getDbConnect();
$tableStudent->setDbConnection($connection);
$tableAnon = new TableAnon("tableanonymous");
$tableAnon->setDbConnection($connection);
$tableFac = new TableFac("tablefaculty");
$tableFac->setDbConnection($connection);
$tableQuestions = new TableQuestion("tablequestion");
$tableQuestions->setDbConnection($connection);
$tableAnswers = new TableAnswer("tableanswer");
$tableAnswers->setDbConnection($connection);

