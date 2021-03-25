<?php

namespace DesignPattern\AbstractFactory;


class ConnectionFactory
{

    private $IdbConnection = null;

    public function __construct(IDatabaseFactory $IDataBaseFactory)
    {
        $this->IdbConnection = $IDataBaseFactory->createDatabaseConect();
    }

    public function dbConnect()
    {
        return $this->IdbConnection->connectDbInstance();
    }

    public function dbDisconnect()
    {
        $this->IdbConnection->closeDbInstance();
    }
    public function getIdbConnection(): ?DBMySqlConnectSingle
    {
        return $this->IdbConnection;
    }
}