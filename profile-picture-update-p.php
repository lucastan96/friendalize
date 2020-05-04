<?php

$request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);

if ($request_method == 'POST') {
    session_start();
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT);

    require_once('includes/connection.php');

    $target_dir = "images/profiles/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    $query1 = "SELECT * FROM users WHERE user_id = :user_id";
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(":user_id", $user_id);
    $statement1->execute();
    $result_array1 = $statement1->fetch();
    $statement1->closeCursor();

    $pic_name = $target_dir . "user_" . $user_id . "." . $imageFileType;
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $pic_name)) {
        $fileName = "user_" . $user_id . "." . $imageFileType;
        $query = "UPDATE users SET profile_pic = :image WHERE user_id=:user_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $user_id);
        $statement->bindValue(':image', $fileName);
        $statement->execute();
        $statement->closeCursor();
    }

    header("Location: http://localhost/friendalize/settings");
    exit();
}

