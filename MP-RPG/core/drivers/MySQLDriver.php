<?php

namespace Core\Drivers;

include_once 'DriverAbstract.php';
/**
 * Class MySQLDriver
 * @package Core\Drivers
 */
class MySQLDriver extends DriverAbstract
{
    /**
     * @return string
     */
    public function getDsn()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->dbName";

        return $dsn;
    }
}