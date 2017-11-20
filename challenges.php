<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
} else {
    require_once('includes/essentials.php');

    $query = 'SELECT * FROM ghost_room';
    $statement = $db->prepare($query);
    $statement->execute();
    $rooms = $statement->fetchAll();
    $statement->closeCursor();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("includes/head.php"); ?>
        <title>Challenges | Friendalize</title>
        <link href="styles/challenges.css" rel="stylesheet">
    </head>
    <body>
        <div class="container-fluid">
            <?php include("includes/navbar.php"); ?>
            <div class="row cols">
                <?php include("includes/nav-desktop.php"); ?>
                <?php include("includes/nav-mobile.php"); ?>
                <div class="col-sm-10 content">
                    <h1>Challenges</h1>
                    <?php
                    foreach ($rooms as $room) {
                        $query2 = 'SELECT  count(*) as num FROM ghost_room_players WHERE room_id  =:room_id';
                        $statement2 = $db->prepare($query2);
                        $statement2->execute(array(":room_id" => $room["room_id"]));
                        $result = $statement2->fetch();
                        $statement2->closeCursor();
                        if ($result["num"] < $room["member_num"]) {
                            echo $room["room_name"];
                            echo "<form action='ghost_v3/enter_room_action.php' method='post'>";
                            echo "<input type='hidden' name='room_id' value='" . $room["room_id"] . "'>";
                            echo "<button type='submit' class='select-room-btn'>Join</button>";
                            echo "</form>";
                            echo "<br>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('.nav-desktop li:nth-child(4)').addClass("nav-active");
                $('.nav-mobile a:nth-child(4)').addClass("nav-active");
            });

            var width = $('.nav-mobile a:nth-child(1)').width() + $('.nav-mobile a:nth-child(2)').width() + $('.nav-mobile a:nth-child(3)').width();
            $('.nav-mobile').scrollLeft(width);
        </script>
    </body>
</html>