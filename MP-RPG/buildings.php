<?php

require_once 'index.php';

if (!$app->isLogged()) {
    header('Location: login.php');
}

$buildings = $app->createBuildings();

$app->generateToken();

loadTemplate('buildings', $buildings);

if (isset($_GET['id'])) {
    $_POST['token'] = $_SESSION['token'];
    $app->verifyToken();

    try {
        $buildings->evolve($_GET['id']);
        header('Location: buildings.php');
        exit;
    } catch(Exception $e) {
        echo $e->getMessage();
    }
}
