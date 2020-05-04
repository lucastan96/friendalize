<?php

$request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);

if ($request_method == 'POST') {
    session_start();

    $id = $_SESSION['user_id'];
    $institution_id = filter_input(INPUT_POST, 'institution', FILTER_VALIDATE_INT);
    $interests_array = filter_input(INPUT_POST, 'interests', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

    require_once('connection.php');

    $query1 = "UPDATE user_institutions SET institution_id = :institution_id WHERE user_id = :user_id";
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(":institution_id", $institution_id);
    $statement1->bindValue(":user_id", $id);
    $statement1->execute();
    $statement1->closeCursor();

    if (!empty($interests_array)) {
        $interests_str = "";

        foreach ($interests_array as $interests):
            $interests_str = $interests_str . $interests . ",";
        endforeach;

        $interests_str = substr($interests_str, 0, -1);

        $query2 = "UPDATE user_interests SET interests = :interests WHERE user_id = :user_id";
        $statement2 = $db->prepare($query2);
        $statement2->bindValue(":user_id", $id);
        $statement2->bindValue(":interests", $interests_str);
        $statement2->execute();
        $statement2->closeCursor();
    }

    $_SESSION['first_login'] = 1;

    header("Location: http://localhost/friendalize/get-started");
    exit();
} else {
    header("Location: http://localhost/friendalize/signin");
    exit();
}

