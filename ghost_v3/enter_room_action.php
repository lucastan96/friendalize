<?php
session_start();

require_once('../includes/connection.php');

$room_id = $_POST["room_id"];

$query = 'INSERT INTO ghost_room_players (room_id, user_id) VALUES (:room_id, :user_id)';
$statement = $db->prepare($query);
$statement->execute(array(":room_id" => $room_id, ":user_id" => $_SESSION["user_id"]));
$statement->closeCursor();

$query2 = 'INSERT INTO ghost_answer_submit (room_id, voter,voted) VALUES (:room_id, :voter,0)';
$statement2 = $db->prepare($query2);
$statement2->execute(array(":voter" => $_SESSION["user_id"], ":room_id" => $room_id));
$statement2->closeCursor();

header("Location: room.php?room_id=" . $room_id);
exit();