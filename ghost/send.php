<?php


require_once('../includes/connection.php');
    session_start();

if (isset($_SESSION["user_id"]) && isset($_POST['content'])) {
    $msg = $_POST['content'];
    $room_id = $_POST['room_id'];
   
}
echo 'content'.$_POST['content'];
echo 'player id '.$_SESSION["user_id"];

if (isset($msg)) {
    $query = "INSERT INTO ghost_message (content,created_at) VALUES (:content,NOW())";
    $statement = $db->prepare($query);
    $statement->execute(array(":content"=>$msg));
    
    $statement->closeCursor();
     $last_id = $db->lastInsertId();

    $query1 = "INSERT INTO ghost_msg_player_room (message_id,room_id,user_id) VALUES (:message_id,:room_id,:user_id)";
    $statement1 = $db->prepare($query1);
    $statement1->execute(array(":message_id"=>$last_id,":room_id"=>$room_id,":user_id"=>$_SESSION["user_id"]));
    $statement1->closeCursor();

}
?>