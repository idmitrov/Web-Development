<?php

require_once 'index.php';

$app->generateToken();

loadTemplate('login');

if (isset($_POST['username'], $_POST['password'], $_POST['token'], $_POST['submit'])) {
    try {
        $app->verifyToken();
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $app->login($user, $pass);
        header('Location: profile.php');
    } catch(Exception $e) {
        echo $e->getMessage();
    }
}
