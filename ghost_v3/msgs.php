<?php

require_once('../includes/connection.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$query = "SELECT m.created_at,m.content,p.username, p.user_id,r.room_name FROM ghost_message m, users p,ghost_msg_player_room mpr, ghost_room r WHERE m.message_id = mpr.message_id AND p.user_id= mpr.user_id AND r.room_id = mpr.room_id  AND m.message_id = mpr.message_id AND r.room_id=:room_id ORDER BY m.created_at";
$statement = $db->prepare($query);
$statement->execute(array(":room_id" => $_SESSION["room_id"]));
$messages = $statement->fetchAll();
$statement->closeCursor();

foreach ($messages as $msg) {
    if ($msg['user_id'] == $_SESSION["user_id"]) {
        echo "<div class='msg right'><span class='msg-name'>{$msg['username']}</span><div class='msgc' title='{$msg['created_at']}'><span>{$msg['content']}</span></div></div>";
    } else {
//        echo "<b><span class='name'>{$r['username']}</span></b>";
        echo "<div class='msg left'><span class='msg-name'>{$msg['username']}</span><div class='msgc' title='{$msg['created_at']}'><span>{$msg['content']}</span></div></div>";
    }
}

//while($r=$sql->fetch()){
// echo "<div class='msg' title='{$r['created_at']}'><span class='name'>{$r['name']}</span> : <span class='msgc'>{$r['msg']}</span></div>";
//}
//if(!isset($_SESSION['user']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest'){
// echo "<script>window.location.reload()</script>";
//}
?>