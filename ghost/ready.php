<?php

require_once('../includes/connection.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$data = array();

$query2 = 'SELECT * FROM ghost_room gr, ghost_room_players rp WHERE  rp.room_id=gr.room_id AND rp.user_id=:user_id AND rp.room_id=:room_id';
$statement2 = $db->prepare($query2);
$statement2->execute(array(":user_id" => $_SESSION["user_id"], ":room_id" => $_SESSION["room_id"]));
$player = $statement2->fetch();
$statement2->closeCursor();

$mem_num =$player['member_num'];

$query3 = 'SELECT COUNT(*) as num_ready FROM ghost_room r , ghost_room_players rp WHERE r.room_id = rp.room_id AND r.room_id = :room_id AND rp.ready = 1';
$statement3 = $db->prepare($query3);
$statement3->execute(array(":room_id" => $_SESSION["room_id"]));
$result = $statement3->fetch();
$statement3->closeCursor();
$data["num_ready"] = $result["num_ready"];
$data["user_ready"] = $player['ready'];
$data["room_id"] = $_SESSION["room_id"];
$data["mem_num"]=$mem_num;
echo json_encode($data);
?>
