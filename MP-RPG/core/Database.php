<?php

namespace Core;

use Core\Drivers\DriverFactory;

/**
 * Class Database
 * @package Core
 */
class Database
{
    static $inst = array();

    private $db = null;

    private function __construct(\PDO $pdoInstance) {
        $this->db = $pdoInstance;
    }

    /**
     * @param string $instanceName
     * @return mixed
     * @throws \Exception
     */
    public static function getInstance($instanceName = 'default') {
        if (!isset(self::$inst[$instanceName])) {
            throw new \Exception('Instance with that name was not set');
        }

        return self::$inst[$instanceName];
    }

    /**
     * @param $instanceName
     * @param $driver
     * @param $user
     * @param $pass
     * @param $dbName
     * @param null $host
     * @throws \Exception
     */
    public static function setInstance($instanceName, $driver, $user, $pass, $dbName, $host = null) {
        $driver = DriverFactory::create($driver, $user, $pass, $dbName, $host);

        $pdo = new \PDO(
            $driver->getDsn(),
            $user,
            $pass
        );

        self::$inst[$instanceName] = new self($pdo);
    }

    /**
     * @param $statement
     * @param array $driverOptions
     * @return Statement
     */
    public function prepare($statement, array $driverOptions = array()) {
        $statement = $this->db->prepare($statement, $driverOptions);

        return new Statement($statement);
    }

    /**
     * @param $query
     */
    public function query($query) {
        $this->db->query($query);
    }

    /**
     * @param null $name
     * @return string
     */
    public function lastId($name = null) {
        return $this->db->lastInsertId($name);
    }
}