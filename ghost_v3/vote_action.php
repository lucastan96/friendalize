<?php


require_once('../includes/connection.php');
session_start();
$voted = $_POST["voted"];

$query = 'UPDATE ghost_answer_submit  SET voted=:voted WHERE  room_id = :room_id AND  voter = :voter';
$statement = $db->prepare($query);
$statement->execute(array(":voted" => $voted, ":voter" => $_SESSION["user_id"], ":room_id" => $_SESSION["room_id"]));
$statement->closeCursor();

$_SESSION["vote"] = true;
//SELECT voted, COUNT(voted) AS value_occurrence FROM answer_submit WHERE room_id=3 GROUP BY voted ORDER BY value_occurrence  desc limit 1
//check everyone enter
//$query3 = 'SELECT count(*) as count_0 FROM answer_submit WHERE room_id=:room_id  and voted = 0';
//$statement3 = $db->prepare($query3);
//$statement3->execute(array(":room_id" => $_SESSION["room_id"]));
//$r = $statement3->fetch();
//$statement3->closeCursor();
//$count_0 = $r["count_0"];
//$draw = false;
//if ($count_0 == 0) {
//    $query2 = 'SELECT voted, COUNT(voted) AS value_occurrence FROM answer_submit WHERE room_id=:room_id GROUP BY voted ORDER BY value_occurrence';
//    $statement2 = $db->prepare($query2);
//    $statement2->execute(array(":room_id" => $_SESSION["room_id"]));
//    $answer = $statement2->fetchAll();
//    $statement2->closeCursor();
//
//    $max = 0;
//    $die_id = 0;
//    foreach ($answer as $a) {
//        if ($a["value_occurrence"] > $max) {
////            echo $a["value_occurrence"];
//            $die_id = $a["voted"];
//            $max = $a["value_occurrence"];
//        }
//    }
//    foreach ($answer as $a) {
//        if ($a["value_occurrence"] == $max &&  $die_id !=$a["voted"]) {
//            $draw = true;
//        }
//    }
//    if ($draw) {
//        echo "Ghost not found";
//    } else {
//        echo $die_id;
//    }
//} else {
//    echo "Wait for other players to vote";
//}