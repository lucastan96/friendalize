<?php

$request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);

if ($request_method == 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $register_email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $regex_email = "/[a-z]"
            . "[a-z0-9.-_]*"
            . "[a-z0-9]+"
            . "[@]"
            . "[a-z0-9]+"
            . "\."
            . "("
            . "([a-z]{2}\.[a-z]{2})"
            . "|"
            . "[a-z]{2,3})"
            . "/";

    if (!preg_match($regex_email, $register_email)) {
        $register_message = "<i class='fa fa-info-circle' aria-hidden='true'></i>The email format is incorrect.<div><i class='fa fa-times' aria-hidden='true'></i></div>";

        include ("register.php");
        exit();
    }

    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $regex_password = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";

    if (!preg_match($regex_password, $password)) {
        $register_message = "<i class='fa fa-info-circle' aria-hidden='true'></i>The password format is incorrect.<div><i class='fa fa-times' aria-hidden='true'></i></div>";

        include ("register.php");
        exit();
    }

    $confirmpassword = filter_input(INPUT_POST, 'password_confirm', FILTER_SANITIZE_STRING);
    $firstname = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
    $lastname = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
    $age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT);
    $gender = filter_input(INPUT_POST, 'gender', FILTER_VALIDATE_INT);
    $country_id = filter_input(INPUT_POST, 'country', FILTER_VALIDATE_INT);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    if ($password == $confirmpassword) {
        require_once('includes/connection.php');

        $query1 = "SELECT * FROM users where username = :username AND email = :email";
        $statement1 = $db->prepare($query1);
        $statement1->bindValue(":email", $register_email);
        $statement1->bindValue(":username", $username);
        $statement1->execute();
        $result_array1 = $statement1->fetchAll();
        $statement1->closeCursor();

        if (!count($result_array1)) {
            $query2 = "INSERT INTO users (username, password, email, first_name, last_name, age, gender, country_id)"
                    . " VALUES (:username, :password, :email, :first_name, :last_name, :age, :gender, :country_id  )";
            $statement2 = $db->prepare($query2);
            $statement2->bindValue(":username", $username);
            $statement2->bindValue(":email", $register_email);
            $statement2->bindValue(":password", $hashed_password);
            $statement2->bindValue(":first_name", $firstname);
            $statement2->bindValue(":last_name", $lastname);
            $statement2->bindValue(":age", $age);
            $statement2->bindValue(":gender", $gender);
            $statement2->bindValue(":country_id", $country_id);
            $statement2->execute();
            $statement2->closeCursor();

            $query3 = "SELECT user_id FROM users where username = :username";
            $statement3 = $db->prepare($query3);
            $statement3->bindValue(":username", $username);
            $statement3->execute();
            $result_array3 = $statement3->fetch();
            $statement3->closeCursor();

            session_start();

            $_SESSION['user_id'] = $result_array3['user_id'];
            $_SESSION['username'] = $username;
//            $_SESSION['user_status'] = 0;
            
            $query4 = "INSERT INTO user_institutions (user_id) VALUES (:user_id)";
            $statement4 = $db->prepare($query4);
            $statement4->bindValue(":user_id", $_SESSION['user_id']);
            $statement4->execute();
            $statement4->closeCursor();

            $query5 = "INSERT INTO user_interests (user_id) VALUES (:user_id)";
            $statement5 = $db->prepare($query5);
            $statement5->bindValue(":user_id", $_SESSION['user_id']);
            $statement5->execute();
            $statement5->closeCursor();
            
            $query6 = "INSERT INTO user_friends (user_id) VALUES (:user_id)";
            $statement6 = $db->prepare($query6);
            $statement6->bindValue(":user_id", $_SESSION['user_id']);
            $statement6->execute();
            $statement6->closeCursor();
            
            header("Location: setup-institution.php");
            exit();
        } else {
            $register_message = "<i class='fa fa-info-circle' aria-hidden='true'></i>Your username or email is not available.<div><i class='fa fa-times' aria-hidden='true'></i></div>";
        }
    } else {
        $register_message = "<i class='fa fa-info-circle' aria-hidden='true'></i>Your passwords does not match.<div><i class='fa fa-times' aria-hidden='true'></i></div>";
    }

    if (isset($register_message)) {
        include ("register.php");
        exit();
    }
} else {
    header("Location: signin.php");
    exit();
}


