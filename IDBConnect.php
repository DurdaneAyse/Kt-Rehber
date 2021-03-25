<?php
namespace DesignPattern\AbstractFactory;
interface IDBConnect
{
    public static function getDbInstance();
    public static function closeDbInstance();
    public function getDbConnect();
}