<?php

$request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);

if ($request_method == 'POST') {
    session_start();

    $user_id = $_SESSION['user_id'];
    $confirmpassword = filter_input(INPUT_POST, 'password_confirm', FILTER_SANITIZE_STRING);
    $hashed_password = password_hash($confirmpassword, PASSWORD_DEFAULT);

    require_once('includes/connection.php');

    $query4 = "UPDATE users SET password = :password WHERE user_id = :user_id";
    $statement4 = $db->prepare($query4);
    $statement4->bindValue(":password", $hashed_password);
    $statement4->bindValue(":user_id", $user_id);
    $statement4->execute();
    $statement4->closeCursor();

    header("Location: settings.php");
    exit();
} else {
    header("Location: settings.php");
    exit();
}

