<?php

$request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);

if ($request_method == 'POST') {
    require_once('includes/connection.php');

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);

    $query = "SELECT * FROM users WHERE username=:username";
    $statement = $db->prepare($query);
    $statement->bindValue(":username", $username);
    $statement->execute();
    $result_array = $statement->fetchAll();
    $statement->closeCursor();

    if (count($result_array)) {
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        foreach ($result_array as $result):
            $true_password = $result['password'];
        endforeach;

        if (!password_verify($password, $true_password)) {
            $login_message = "<i class='fa fa-info-circle' aria-hidden='true'></i>Your username or password is incorrect.<div><i class='fa fa-times' aria-hidden='true'></i></div>";

        } else {
            session_start();

            foreach ($result_array as $result):
                $_SESSION['user_id'] = $result['user_id'];
//                $_SESSION['user_status'] = $result['user_status'];
            endforeach;

            $_SESSION['username'] = $username;

            header("Location: index.php");
            exit();
        }
    } else {
        $login_message = "<i class='fa fa-info-circle' aria-hidden='true'></i>Your username or password is incorrect.<div><i class='fa fa-times' aria-hidden='true'></i></div>";
    }

    if (isset($login_message)) {
        include ("signin.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
