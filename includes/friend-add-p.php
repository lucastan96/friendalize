<?php

$request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);

if ($request_method == 'POST') {
    session_start();

    $user_id = $_SESSION['user_id'];
    $friend_id = filter_input(INPUT_POST, 'friend_id', FILTER_VALIDATE_INT);

    require_once('connection.php');

    $query1 = "SELECT friends FROM user_friends WHERE user_id = :user_id";
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(":user_id", $user_id);
    $statement1->execute();
    $results_array1 = $statement1->fetch();
    $statement1->closeCursor();

    $friend_ids = $results_array1["friends"];
    $friends_array = explode(",", $friend_ids);

    if (in_array($friend_id, $friends_array)) {
        header("Location: http://localhost/friendalize/profile?id=$friend_id");
        exit();
    } else {
        $query2 = "SELECT requests FROM user_friends WHERE user_id = :user_id";
        $statement2 = $db->prepare($query2);
        $statement2->bindValue(":user_id", $user_id);
        $statement2->execute();
        $results2 = $statement2->fetch();
        $statement2->closeCursor();

        $requests = $results2["requests"];
        $requests_array = explode(",", $requests);
        $requests_array_new = array_diff($requests_array, [$friend_id]);
        $requests_new = implode(",", $requests_array_new);

        $query3 = "SELECT friends FROM user_friends WHERE user_id = :user_id";
        $statement3 = $db->prepare($query3);
        $statement3->bindValue(":user_id", $user_id);
        $statement3->execute();
        $results3 = $statement3->fetch();
        $statement3->closeCursor();

        $friends = $results3["friends"];

        if ($friends != NULL) {
            $friends = $friends . "," . $friend_id;
        } else {
            $friends = $friend_id;
        }

        if ($requests_new == "") {
            $query4 = "UPDATE user_friends SET requests = NULL WHERE user_id = :friend_id";
            $statement4 = $db->prepare($query4);
            $statement4->bindValue(":friend_id", $friend_id);
            $statement4->execute();
            $statement4->closeCursor();
        } else {
            $query4 = "UPDATE user_friends SET requests = :requests WHERE user_id = :friend_id";
            $statement4 = $db->prepare($query4);
            $statement4->bindValue(":requests", $requests_new);
            $statement4->bindValue(":friend_id", $friend_id);
            $statement4->execute();
            $statement4->closeCursor();
        }

        $query5 = "UPDATE user_friends SET friends = :friends WHERE user_id = :user_id";
        $statement5 = $db->prepare($query5);
        $statement5->bindValue(":friends", $friends);
        $statement5->bindValue(":user_id", $user_id);
        $statement5->execute();
        $statement5->closeCursor();

        $query6 = "SELECT friends FROM user_friends WHERE user_id = :friend_id";
        $statement6 = $db->prepare($query6);
        $statement6->bindValue(":friend_id", $friend_id);
        $statement6->execute();
        $results6 = $statement6->fetch();
        $statement6->closeCursor();

        $friend_friends = $results6["friends"];

        if ($friend_friends != NULL) {
            $friend_friends = $friend_friends . "," . $user_id;
        } else {
            $friend_friends = $user_id;
        }

        $query7 = "UPDATE user_friends SET friends = :friends WHERE user_id = :friend_id";
        $statement7 = $db->prepare($query7);
        $statement7->bindValue(":friends", $friend_friends);
        $statement7->bindValue(":friend_id", $friend_id);
        $statement7->execute();
        $statement7->closeCursor();

        header("Location: http://localhost/friendalize/profile?id=$friend_id");
        exit();
    }
} else {
    header("Location: http://localhost/friendalize/profile?id=$friend_id");
    exit();
}    