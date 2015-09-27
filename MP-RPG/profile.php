<?php

use \Core\User;

include_once 'index.php';

if (!$app->isLogged()) {
    header('Location: login.php');
    exit;
}

$app->generateToken();

loadTemplate('profile', $app->getUser());

if (isset($_POST['edit'], $_POST['username'], $_POST['password'], $_POST['confirm_password'], $_POST['token'])) {
    $app->verifyToken();
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($password) || $password != $confirm_password) {
        header('Location: profile.php?error=1');
        exit;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);
    $logged_user_id = $_SESSION['id'];

    $user = new User($username, $password, $logged_user_id);

    if ($app->editUser($user)) {
        header('Location: profile.php?success=1');
        exit;
    }

    header('Location: profile.php?error=1');
    exit;
}
