<?php

session_start();

require_once('../includes/connection.php');

$query = 'SELECT p.profile_pic, p.first_name, p.last_name, p.user_id FROM ghost_room_players rp, users p WHERE rp.room_id = :room_id AND rp.ready = 1 AND p.user_id = rp.user_id';
$statement = $db->prepare($query);
$statement->execute(array(":room_id" => $_SESSION["room_id"]));
$player_info = $statement->fetchAll();
$statement->closeCursor();

foreach ($player_info as $player):
    echo "<a href='../profile.php?id={$player["user_id"]}' target='_blank'><img src='../images/profiles/{$player["profile_pic"]}' title='{$player["first_name"]} {$player["last_name"]}'></a>";
endforeach;