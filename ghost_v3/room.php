<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
} else {
    require_once('../includes/connection.php');
    $room_id = $_GET["room_id"];

//$query = 'INSERT INTO room_player (room_id, user_id) VALUES (:room_id, :user_id)';
//$statement = $db->prepare($query);
//$statement->execute(array(":room_id" => $room_id,":user_id" => $_SESSION["user_id"]));
//$statement->closeCursor();
//$query1 = 'SELECT rp.word, rp.died , rp.ready, p.name,p.user_id FROM room r, room_player rp, users p WHERE p.user_id = rp.user_id AND r.room_id = rp.room_id AND r.room_id = :room_id';
//$statement1 = $db->prepare($query1);
//$statement1->execute(array(":room_id" => $room_id));
//$players = $statement1->fetchAll();
//$statement1->closeCursor();

    $query2 = 'SELECT * FROM ghost_room r, ghost_room_players rp, users p WHERE p.user_id = rp.user_id AND r.room_id = rp.room_id AND r.room_id = :room_id AND p.user_id = :user_id';
    $statement2 = $db->prepare($query2);
    $statement2->execute(array(":room_id" => $room_id, ":user_id" => $_SESSION['user_id']));
    $player = $statement2->fetch();
    $statement2->closeCursor();


    $_SESSION['room_id'] = $room_id;
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://use.fontawesome.com/487ba7c19c.js"></script>
        <script src="room.js" type="text/javascript"></script>
        <link href="chat.css" rel="stylesheet" type="text/css"/>
        <script src="ready.js" type="text/javascript"></script>
    </head>
    <body>
        <!--<input type="hidden" name ="room_id" id="room_id" value="<?php echo $room_id ?>">-->
        <div class="container-fluid" style="margin: 5%;">
            <div class="row">
                <div class="col-sm-8">
                    <div class="chat">
                        <!--                        <div class="header">
                                                    <div class="row">
                                                        <div class="col-xs-6">
                                                            <h3><?php echo $room_id; ?></h3>
                                                        </div>
                                                        <div class="col-xs-offset-1 col-xs-5">
                                                            <i class="fa fa-users fa-2x" aria-hidden="true"></i>
                                                            <a href="logout.php"><i class="fa fa-sign-out fa-2x" aria-hidden="true"></i></a>
                                                        </div>
                                                    </div>
                        
                                                </div>-->
                        <div class='msgs'>
                            <div class="row">
                                <div class="col-xs-12">
                                    <?php include ("msgs.php"); ?>
                                </div>
                            </div>

                        </div>
                        <div class="footer">
                            <form id="msg_form" class="form-inline">
                                <div class="row">
                                    <div class="col-xs-9">
                                        <div class="form-group">
                                            <input name="msg" class="form-control"  size="30" type="text"/>
                                            <input type="hidden"  name ="room_id" id="room_id" value="<?php echo $room_id ?>">
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <button class="btn btn-default"><i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                                    </div>

                                </div>


                            </form>
                        </div>

                    </div>
                </div>
                <!--                  <button type="button" id="ready-btn">or Others</button>-->
                <div class="col-sm-4">
                    <div class='ready'>

                        <?php include_once 'ready.php'; ?>

                    </div>

                    <span id="countdown" class="timer"></span>
                    <div class='timer'>


                        <!--                            <div class="row">
                                                        <div class="col-xs-12">-->
                        <?php include_once 'timer.php'; ?>
                        <!--                                </div>
                                                    </div>-->

                    </div>

                </div>
            </div>
        </div>
    </body>
</html>