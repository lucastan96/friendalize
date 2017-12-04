<?php

require_once('../includes/connection.php');
session_start();
$voted = $_POST["voted"];
$result = array();
$query1 = "SELECT MAX(`vote_order`) as max FROM `ghost_answer_submit` WHERE room_id=:room_id";
$statement1 = $db->prepare($query1);
$statement1->execute(array(":room_id" => $_SESSION["room_id"]));
$r = $statement1->fetch();
$statement1->closeCursor();

$query = 'UPDATE ghost_answer_submit  SET voted=:voted,vote_order = :vote_order WHERE  room_id = :room_id AND  voter = :voter';
$statement = $db->prepare($query);
$statement->execute(array(":voted" => $voted, ":voter" => $_SESSION["user_id"], ":room_id" => $_SESSION["room_id"], ":vote_order" => $r['max'] + 1));
$statement->closeCursor();

$_SESSION["vote"] = true;

$result["r"] = $r;
$result["room_id"] = $_SESSION["room_id"];
echo json_encode($result);
