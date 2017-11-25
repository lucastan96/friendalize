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
    $results1 = $statement1->fetch();
    $statement1->closeCursor();

    $friends = $results1["friends"];
    $friends_array = explode(",", $friends);

    if (in_array($friend_id, $friends_array)) {
        $friends_array_new = array_diff($friends_array, [$friend_id]);
        $friends_new = implode(",", $friends_array_new);

        if ($friends_new == "") {
            $query2 = "UPDATE user_friends SET friends = NULL WHERE user_id = :user_id";
            $statement2 = $db->prepare($query2);
            $statement2->bindValue(":user_id", $user_id);
            $statement2->execute();
            $statement2->closeCursor();
        } else {
            $query2 = "UPDATE user_friends SET friends = :friends WHERE user_id = :user_id";
            $statement2 = $db->prepare($query2);
            $statement2->bindValue(":friends", $friends_new);
            $statement2->bindValue(":user_id", $user_id);
            $statement2->execute();
            $statement2->closeCursor();
        }

        $query3 = "SELECT friends FROM user_friends WHERE user_id = :friend_id";
        $statement3 = $db->prepare($query3);
        $statement3->bindValue(":friend_id", $friend_id);
        $statement3->execute();
        $results3 = $statement3->fetch();
        $statement3->closeCursor();

        $friend_friends = $results3["friends"];
        $friend_friends_array = explode(",", $friend_friends);
        $friend_friends_array_new = array_diff($friend_friends_array, [$user_id]);
        $friend_friends_new = implode(",", $friend_friends_array_new);

        if ($friend_friends_new == "") {
            $query4 = "UPDATE user_friends SET friends = NULL WHERE user_id = :friend_id";
            $statement4 = $db->prepare($query4);
            $statement4->bindValue(":friend_id", $friend_id);
            $statement4->execute();
            $statement4->closeCursor();
        } else {
            $query4 = "UPDATE user_friends SET friends = :friends WHERE user_id = :friend_id";
            $statement4 = $db->prepare($query4);
            $statement4->bindValue(":friends", $friend_friends_new);
            $statement4->bindValue(":friend_id", $friend_id);
            $statement4->execute();
            $statement4->closeCursor();
        }

        header("Location: ../profile.php?id=$friend_id");
        exit();
    } else {
        header("Location: ../profile.php?id=$friend_id");
        exit();
    }
} else {
    header("Location: ../profile.php?id=$friend_id");
    exit();
}