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
        $query2 = "SELECT requests FROM user_friends WHERE user_id = :friend_id";
        $statement2 = $db->prepare($query2);
        $statement2->bindValue(":friend_id", $friend_id);
        $statement2->execute();
        $results2 = $statement2->fetch();
        $statement2->closeCursor();

        $request_ids = $results2["requests"];
        $requests_array = explode(",", $request_ids);

        if (in_array($user_id, $requests_array)) {
            header("Location: http://localhost/friendalize/profile?id=$friend_id");
            exit();
        } else {
            $query3 = "SELECT requests FROM user_friends WHERE user_id = :user_id";
            $statement3 = $db->prepare($query3);
            $statement3->bindValue(":user_id", $user_id);
            $statement3->execute();
            $results3 = $statement3->fetch();
            $statement3->closeCursor();

            $requests = $results3["requests"];

            if ($requests != NULL) {
                $requests = $requests . "," . $friend_id;
            } else {
                $requests = $friend_id;
            }

            $query4 = "UPDATE user_friends SET requests = :requests WHERE user_id = :user_id";
            $statement4 = $db->prepare($query4);
            $statement4->bindValue(":requests", $requests);
            $statement4->bindValue(":user_id", $user_id);
            $statement4->execute();
            $statement4->closeCursor();

            header("Location: http://localhost/friendalize/profile?id=$friend_id");
            exit();
        }
    }
} else {
    header("Location: http://localhost/friendalize/profile?id=$friend_id");
    exit();
}
