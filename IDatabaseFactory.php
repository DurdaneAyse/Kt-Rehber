<?php
namespace DesignPattern\AbstractFactory;
interface IDatabaseFactory{
    public function createDatabaseConect():IDBConnect;
}