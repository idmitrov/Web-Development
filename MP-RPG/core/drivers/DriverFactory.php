<?php

namespace Core\Drivers;
/**
 * Class DriverFactory
 * @package Core\Drivers
 */
class DriverFactory
{
    public static function create($driver, $user, $pass, $dbName, $host) {
        switch($driver){
            case 'mysql':
                return new MySQLDriver($user, $pass, $dbName, $host);
            break;
            default: throw new \Exception('Unknown driver');
        }
    }
}