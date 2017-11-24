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
                    <a href="javascript:window.location.reload(true)" role='button' class='btn btn-square btn-refresh'>Refresh</a>
                    <div class="filter-box">
                        <p>Showing all challenges</p>
                        <select class="form-control form-select" id="filter-select" name="filter-select" required>
                            <option value="" selected="selected">Filter</option>
                        </select>
                    </div>
                    <div class='col-sm-4 col-sm-push-8 challenges-add'>
                        <h2>Create a New Room</h2>
                        <form class="form-horizontal" action="includes/challenge-add-p.php" method="post">
                            <div class="form-group">
                                <label class="control-label" for="challenge">Challenge:</label>
                                <select class="form-control form-select" id="challenge" name="challenge" required>
                                    <option value="" selected="selected">What game do you wanna play today?</option>
                                    <option value="1">Who's the Ghost?</option>
                                    <option value="2" disabled>Quiz (Coming Soon)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="room_name">Room Name (Optional):</label>
                                <input class='form-control form-input' type='text' name='room_name' placeholder="Type a name for the room, be creative!">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="member_num">Players Allowed:</label>
                                <select class='form-control form-select' id="member_num" name="member_num" required>
                                    <option value="" selected="selected">Game of 3, 4, or 5 person?</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-square" type="submit">Create<i class="fa fa-chevron-right" aria-hidden="true"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class='col-sm-8 col-sm-pull-4 challenges-list'>
                        <?php
                        foreach ($rooms as $room) {
                            $query2 = 'SELECT  count(*) as num FROM ghost_room_players WHERE room_id  =:room_id';
                            $statement2 = $db->prepare($query2);
                            $statement2->execute(array(":room_id" => $room["room_id"]));
                            $result = $statement2->fetch();
                            $statement2->closeCursor();
                            if ($result["num"] < $room["member_num"]) {
                                echo "<div class='item'>";
                                echo "<div class='item-name'>Room ID #" . $room["room_id"] . " - " . $room["room_name"] . "</div>";
                                echo "<form action='ghost_v3/enter_room_action.php' method='post'>";
                                echo "<input type='hidden' name='room_id' value='" . $room["room_id"] . "'>";
                                echo "<button type='submit' class='btn btn-square btn-item'>Join</button>";
                                echo "</form>";
                                echo "</div>";
                            }
                        }
                        ?>
                    </div>
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