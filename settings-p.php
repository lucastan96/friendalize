<?php

$request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);

if ($request_method == 'POST') {
    session_start();

    $user_id = $_SESSION['user_id'];
    $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
    $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
    $age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT);
    $gender = filter_input(INPUT_POST, 'gender', FILTER_VALIDATE_INT);
    $country_id = filter_input(INPUT_POST, 'country', FILTER_VALIDATE_INT);
    $institution_id = filter_input(INPUT_POST, 'institution', FILTER_VALIDATE_INT);
    $interests_array = filter_input(INPUT_POST, 'interests', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    

    require_once('includes/connection.php');

    $query1 = "UPDATE users SET first_name = :first_name, last_name = :last_name, age = :age, gender = :gender, country_id = :country_id WHERE user_id = :user_id";
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(":first_name", $first_name);
    $statement1->bindValue(":last_name", $last_name);
    $statement1->bindValue(":age", $age);
    $statement1->bindValue(":gender", $gender);
    $statement1->bindValue(":country_id", $country_id);
    $statement1->bindValue(":user_id", $user_id);
    $statement1->execute();
    $statement1->closeCursor();


    $query2 = "UPDATE user_institutions SET institution_id = :institution_id WHERE user_id = :user_id";
    $statement2 = $db->prepare($query2);
    $statement2->bindValue(":institution_id", $institution_id);
    $statement2->bindValue(":user_id", $user_id);
    $statement2->execute();
    $statement2->closeCursor();

    if (empty($interests_array)) {
        $query3 = "UPDATE user_interests SET interests = NULL WHERE user_id = :user_id";
        $statement3 = $db->prepare($query3);
        $statement3->bindValue(":user_id", $user_id);
        $statement3->execute();
        $statement3->closeCursor();
    } else {
        $interests_str = "";

        foreach ($interests_array as $interests):
            $interests_str = $interests_str . $interests . ",";
        endforeach;

        $interests_str = substr($interests_str, 0, -1);

        $query3 = "UPDATE user_interests SET interests = :interests WHERE user_id = :user_id";
        $statement3 = $db->prepare($query3);
        $statement3->bindValue(":user_id", $user_id);
        $statement3->bindValue(":interests", $interests_str);
        $statement3->execute();
        $statement3->closeCursor();
    }

    header("Location: settings.php");
    exit();
} else {
    header("Location: settings.php");
    exit();
}

