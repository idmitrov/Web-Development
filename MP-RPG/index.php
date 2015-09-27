<?php

use \Core\Database;
use \Config\DatabaseConfig;
use \Core\App;

session_start();

spl_autoload_register(function($class) {
    $classPath = str_replace("\\", "/", $class);
    require_once "$classPath.php";
});

require_once 'core/app.php';

Database::setInstance(
    DatabaseConfig::DB_INSTANCE,
    DatabaseConfig::DB_DRIVER,
    DatabaseConfig::DB_USER,
    DatabaseConfig::DB_PASS,
    DatabaseConfig::DB_NAME,
    DatabaseConfig::DB_HOST
);

$app = new App(Database::getInstance(DatabaseConfig::DB_INSTANCE));

function loadTemplate($templateName, $data = null) {
    require_once "templates/$templateName.php";
}