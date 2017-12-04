<?php

session_start();

require_once('../includes/connection.php');

$room_id = $_POST["room_id"];
$_SESSION["die_num"] = 0;

unset($_SESSION["start_time"]);
unset($_SESSION["vote"]);
unset($_SESSION["next_round"]);
unset($_SESSION['die']);
unset($_SESSION['result_message']);

$query6 = 'SELECT member_num FROM ghost_room WHERE room_id = :room_id';
$statement6 = $db->prepare($query6);
$statement6->execute(array(":room_id" => $room_id));
$results6 = $statement6->fetch();
$statement6->closeCursor();

$query7 = "SELECT COUNT(*) AS users_joined FROM ghost_room_players WHERE room_id = :room_id";
$statement7 = $db->prepare($query7);
$statement7->execute(array(":room_id" => $room_id));
$results7 = $statement7->fetch();
$statement7->closeCursor();

$query8 = "SELECT room_id FROM ghost_room_players WHERE user_id = :user_id AND room_id = :room_id";
$statement8 = $db->prepare($query8);
$statement8->bindValue(":user_id", $_SESSION["user_id"]);
$statement8->bindValue(":room_id", $room_id);
$statement8->execute();
$results8 = $statement8->fetch();
$statement8->closeCursor();

if (empty($results8)) {
    if ($results7["users_joined"] < $results6["member_num"]) {
        $query9 = 'INSERT INTO ghost_room_players (room_id, user_id) VALUES (:room_id, :user_id)';
        $statement9 = $db->prepare($query9);
        $statement9->execute(array(":room_id" => $room_id, ":user_id" => $_SESSION["user_id"]));
        $statement9->closeCursor();

        $query10 = 'INSERT INTO ghost_answer_submit (room_id, voter,voted) VALUES (:room_id, :voter,0)';
        $statement10 = $db->prepare($query10);
        $statement10->execute(array(":voter" => $_SESSION["user_id"], ":room_id" => $room_id));
        $statement10->closeCursor();
    } else {
        header("Location: ../challenges.php");
        exit();
    }
    unset($_SESSION["start_time"]);
}

$query = 'UPDATE ghost_room_players SET ready=1 WHERE room_id=:room_id AND user_id=:user_id';
$statement = $db->prepare($query);
$statement->execute(array(":room_id" => $room_id, ":user_id" => $_SESSION["user_id"]));
$statement->closeCursor();

$query3 = 'SELECT COUNT(*) as num_ready FROM ghost_room r , ghost_room_players rp WHERE r.room_id = rp.room_id AND r.room_id = :room_id AND rp.ready = 1';
$statement3 = $db->prepare($query3);
$statement3->execute(array(":room_id" => $room_id));
$result = $statement3->fetch();
$statement3->closeCursor();

$ready = $result["num_ready"];

if ($ready == 3) {
    $query2 = 'SELECT wp.civilian_word,wp.ghost_word FROM ghost_room r , ghost_word_pair wp WHERE r.room_id = :room_id AND r.word_pair_id = wp.word_pair_id';
    $statement2 = $db->prepare($query2);
    $statement2->execute(array(":room_id" => $room_id));
    $room_info = $statement2->fetch();
    $statement2->closeCursor();

    $civilian_word = $room_info["civilian_word"];
    $ghost_word = $room_info["ghost_word"];

    $query1 = 'SELECT rp.word, rp.died , rp.ready, p.username,p.user_id FROM ghost_room r, ghost_room_players rp, users p WHERE p.user_id = rp.user_id AND r.room_id = rp.room_id AND r.room_id = :room_id';
    $statement1 = $db->prepare($query1);
    $statement1->execute(array(":room_id" => $room_id));
    $players = $statement1->fetchAll();
    $statement1->closeCursor();
    $user_id_array = array();

    foreach ($players as $player) {
        array_push($user_id_array, $player["user_id"]);
    }
    shuffle($user_id_array);
    for ($x = 0; $x < count($user_id_array); $x++) {
        if ($x != 1) {
            $word = $civilian_word;
        } else {
            $word = $ghost_word;
            echo $word;
        }
        $query4 = 'UPDATE ghost_room_players SET word=:word,game_order=:order WHERE room_id=:room_id AND user_id=:user_id';
        $statement4 = $db->prepare($query4);
        $statement4->execute(array(":word" => $word, ":room_id" => $room_id, ":user_id" => $user_id_array[$x], ":order" => $x + 1));
        $statement4->closeCursor();
    }

    $curTime = date("Y-m-d H:i:s", time());
    $query5 = 'INSERT INTO ghost_game_time (room_id,start_time) VALUES(:room_id,:start_time)';
    $statement5 = $db->prepare($query5);
    $statement5->execute(array(":room_id" => $room_id, ":start_time" => $curTime));
    $statement5->closeCursor();
}  

