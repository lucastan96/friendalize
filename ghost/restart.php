<?php

session_start();
require_once('../includes/connection.php');

$query6 = 'SELECT * from ghost_game_time gt, ghost_room r, ghost_word_pair wp  WHERE gt.room_id=r.room_id AND r.word_pair_id = wp.word_pair_id and r.room_id = :room_id';
$statement6 = $db->prepare($query6);
$statement6->execute(array(":room_id" => $_SESSION["room_id"]));
$r3 = $statement6->fetch();
$statement6->closeCursor();
unset($_SESSION["start_time"]);
unset($_SESSION["vote"]);
unset($_SESSION["next_round"]);
unset($_SESSION['die']);
unset($_SESSION['result_message']);
$_SESSION['die_num'] = 0;
$id = $r3["room_id"];
$interest_id =$r3['interest_id'];
if ($id == $_SESSION["room_id"]) {
    $query = 'DELETE FROM ghost_game_time WHERE room_id = :room_id';
    $statement = $db->prepare($query);
    $statement->execute(array(":room_id" => $_SESSION["room_id"]));
    $statement->closeCursor();

    $query1 = 'UPDATE ghost_room_players SET ready=0, died=0,game_order=0 WHERE room_id = :room_id';
    $statement1 = $db->prepare($query1);
    $statement1->execute(array(":room_id" => $_SESSION["room_id"]));
    $statement1->closeCursor();

    $query2 = 'UPDATE ghost_answer_submit SET voted=0,vote_order=0 WHERE room_id = :room_id';
    $statement2 = $db->prepare($query2);
    $statement2->execute(array(":room_id" => $_SESSION["room_id"]));
    $statement2->closeCursor();


    $query4 = 'SELECT word_pair_id FROM ghost_word_pair WHERE  interest_id= :interest_id ORDER BY RAND() LIMIT 5';
    $statement4 = $db->prepare($query4);
    $statement4->execute(array(":interest_id"=>$interest_id));
    $r1 = $statement4->fetchAll();
    $statement4->closeCursor();
        $new_word=2;
    foreach ($r1 as $value) {
        if ($r3["word_pair_id"] != $value['word_pair_id']) {
            $new_word = $value['word_pair_id'];
        }
    }

    $query3 = 'UPDATE ghost_room SET word_pair_id = :word_pair WHERE room_id = :room_id';
    $statement3 = $db->prepare($query3);
    $statement3->execute(array(":room_id" => $_SESSION["room_id"], ":word_pair" => $new_word));
    $statement3->closeCursor();
}
header("Location: room.php?room_id=" . $_SESSION["room_id"]);
exit();
