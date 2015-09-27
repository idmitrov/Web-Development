<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Guess the number</title>
</head>
<body>
    <form action="#" method="GET">
        <label for="input-number-field">Number: </label>
        <input name="number" id="input-number-field" type="text">
        <input name="submitNumber" type="submit" value="Submit">
    </form>
</body>
</html>
<?php
session_start();

if (isset($_POST['loginUsername']) && isset($_POST['enterGame'])){
    $_SESSION['username'] = $_POST['loginUsername'];

    if (!isset($_SESSION['serverNumber'])){
        $_SESSION['serverNumber'] = rand(0, 100);
    }
}

if (isset($_SESSION['serverNumber'])){
    if (isset($_GET['number']) && isset($_GET['submitNumber'])){
        $userNumber = (int) $_GET['number'];

        if ($userNumber < 1 || $userNumber > 100){
            echo 'Invalid number';
        } else {
            $serverNumber = $_SESSION['serverNumber'];

            if ($userNumber === $serverNumber){
                echo 'Congratulations ' . $_SESSION['username'];
            }
            else if ($userNumber > $serverNumber){
                echo 'DOWN';
            } else if ($userNumber < $serverNumber){
                echo 'UP';
            }
        }
    }
}