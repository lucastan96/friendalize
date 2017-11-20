<?php

$request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);

if ($request_method == 'POST') {
    session_start();
    
    require_once('connection.php');
    
    $challenge = filter_input(INPUT_POST, 'challenge', FILTER_VALIDATE_INT);
    $room_name = filter_input(INPUT_POST, 'room_name', FILTER_SANITIZE_STRING);
    $member_num = filter_input(INPUT_POST, 'member_num', FILTER_VALIDATE_INT);

    if ($challenge == 1) {
        $word_pair_id = 1;
        
        $query1 = 'INSERT INTO ghost_room (room_name, word_pair_id, member_num, created_by) VALUES (:room_name, :word_pair_id, :member_num, :created_by)';
        $statement1 = $db->prepare($query1);
        $statement1->bindValue(":room_name", $room_name);
        $statement1->bindValue(":word_pair_id", $word_pair_id);
        $statement1->bindValue(":member_num", $member_num);
        $statement1->bindValue(":created_by", $_SESSION["user_id"]);
        $statement1->execute();
        $statement1->closeCursor();

        $query2 = "SELECT room_id FROM ghost_room WHERE created_by = :user_id AND room_name = :room_name";
        $statement2 = $db->prepare($query2);
        $statement2->bindValue(":user_id", $_SESSION["user_id"]);
        $statement2->bindValue(":room_name", $room_name);
        $statement2->execute();
        $room_id_array = $statement2->fetch();
        $statement2->closeCursor();
        
        $room_id = $room_id_array["room_id"];
        
        $query3 = 'INSERT INTO ghost_room_players (room_id, user_id, ready) VALUES (:room_id, :user_id, :ready)';
        $statement3 = $db->prepare($query3);
        $statement3->execute(array(":room_id" => $room_id, ":user_id" => $_SESSION["user_id"], ":ready" => 1));
        $statement3->closeCursor();

        $query4 = 'INSERT INTO ghost_answer_submit (room_id, voter, voted) VALUES (:room_id, :voter,0)';
        $statement4 = $db->prepare($query4);
        $statement4->execute(array(":voter" => $_SESSION["user_id"], ":room_id" => $room_id));
        $statement4->closeCursor();

        header("Location: ../ghost_v3/room.php?room_id=" . $room_id);
        exit();
    }
} else {
    header("Location: ../challenges.php");
    exit();
}