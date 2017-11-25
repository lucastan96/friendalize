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

    $query3 = "SELECT room_id FROM ghost_room_players WHERE user_id = :user_id";
    $statement3 = $db->prepare($query3);
    $statement3->bindValue(":user_id", $_SESSION["user_id"]);
    $statement3->execute();
    $results3 = $statement3->fetch();
    $statement3->closeCursor();

    if (empty($results3)) {
        if ($results2["users_joined"] < $results1["member_num"]) {
            $query4 = 'INSERT INTO ghost_room_players (room_id, user_id) VALUES (:room_id, :user_id)';
            $statement4 = $db->prepare($query4);
            $statement4->execute(array(":room_id" => $room_id, ":user_id" => $_SESSION["user_id"]));
            $statement4->closeCursor();

            $query5 = 'INSERT INTO ghost_answer_submit (room_id, voter,voted) VALUES (:room_id, :voter,0)';
            $statement5 = $db->prepare($query5);
            $statement5->execute(array(":voter" => $_SESSION["user_id"], ":room_id" => $room_id));
            $statement5->closeCursor();

            header("Location: room.php?room_id=" . $room_id);
            exit();
        } else {
            header("Location: challenges.php");
            exit();
        }
    } else {
        header("Location: room.php?room_id=" . $room_id);
        exit();
    }
} else {
    header("Location: challenges.php");
    exit();
}