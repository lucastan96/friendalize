<?php

require_once('../includes/connection.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<script src="ready.js" type="text/javascript"></script>
<?php
$query2 = 'SELECT * FROM ghost_room_players WHERE user_id=:user_id AND room_id=:room_id';
$statement2 = $db->prepare($query2);
$statement2->execute(array(":user_id" => $_SESSION["user_id"],":room_id" => $_SESSION["room_id"]));
$player = $statement2->fetch();
$statement2->closeCursor();
//                        $query4 = 'SELECT * FROM room_player WHERE user_id=:user_id';
//                        $statement4 = $db->prepare($query4);
//                        $statement4->execute(array(":user_id" => $_SESSION["user_id"]));
//                        $player = $statement4->fetch();
//                        $statement4->closeCursor();

$query3 = 'SELECT COUNT(*) as num_ready FROM ghost_room r , ghost_room_players rp WHERE r.room_id = rp.room_id AND r.room_id = :room_id AND rp.ready = 1';
$statement3 = $db->prepare($query3);
$statement3->execute(array(":room_id" => $_SESSION["room_id"]));
$result = $statement3->fetch();
$statement3->closeCursor();

$ready = $result["num_ready"];


if ($player['ready'] != 1 && $ready != 3) {
    ?>

      <input type="hidden"  name ="room_id" id="room_id" value="<?php echo $_SESSION["room_id"] ?>">                                  
    <button type="button" id="ready-btn">Ready</button>
    <?php
}
//else if($ready == 3){
//    header()
//}
//else if($player['ready'] == 1 && $ready != 5){
    ?>
<!--    <input type="hidden"  name ="room_id" id="room_id" value="<?php echo $_SESSION["room_id"] ?>">   
    <button type="button" id="ready-btn" disabled>Waiting for others</button>-->
    <?php
//}
?>