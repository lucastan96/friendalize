<?php

$request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);

if ($request_method == 'POST') {
    session_start();

    $id = $_SESSION['user_id'];
    $institution_id = filter_input(INPUT_POST, 'institution', FILTER_VALIDATE_INT);
    require_once('includes/connection.php');


    $query = "UPDATE user_institutions SET institution_id = :institution_id WHERE user_id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(":institution_id", $institution_id);
    $statement->bindValue(":id", $id);
    $statement->execute();
    $statement->closeCursor();

    header("Location: get-started.php");
    exit();
} else {
    header("Location: get-started.php");
    exit();
}

