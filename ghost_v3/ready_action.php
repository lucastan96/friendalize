<?php
session_start();
require_once('../includes/connection.php');

$room_id = $_POST["room_id"];

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

