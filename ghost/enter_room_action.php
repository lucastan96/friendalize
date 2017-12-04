<?php

$request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);

if ($request_method == 'POST') {
    session_start();
    require_once('../includes/connection.php');
    $room_id = filter_input(INPUT_POST, 'room_id', FILTER_VALIDATE_INT);

    $query1 = 'SELECT member_num FROM ghost_room WHERE room_id = :room_id';
    $statement1 = $db->prepare($query1);
    $statement1->execute(array(":room_id" => $room_id));
    $results1 = $statement1->fetch();
    $statement1->closeCursor();

    $query2 = "SELECT COUNT(*) AS users_joined FROM ghost_room_players WHERE room_id = :room_id";
    $statement2 = $db->prepare($query2);
    $statement2->execute(array(":room_id" => $room_id));
    $results2 = $statement2->fetch();
    $statement2->closeCursor();

    $query3 = "SELECT room_id FROM ghost_room_players WHERE user_id = :user_id AND room_id = :room_id";
    $statement3 = $db->prepare($query3);
    $statement3->bindValue(":user_id", $_SESSION["user_id"]);
    $statement3->bindValue(":room_id", $room_id);
    $statement3->execute();
    $results3 = $statement3->fetch();
    $statement3->closeCursor();

    if (empty($results3)) {
        if ($results2["users_joined"] < $results1["member_num"]) {
            header("Location: room.php?room_id=" . $room_id);
            exit();
        } else {
            header("Location: challenges.php");
            exit();
        }
        unset($_SESSION["start_time"]);
    } else {
        header("Location: room.php?room_id=" . $room_id);
        exit();
    }
} else {
    header("Location: challenges.php");
    exit();
}


