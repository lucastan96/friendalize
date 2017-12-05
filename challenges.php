<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
} else {
    require_once('includes/essentials.php');

    $rooms = get_rooms($db);
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
                    <div class="clear"></div>
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
                        if (!empty($rooms)) {
                            foreach ($rooms as $room) {
                                $room_id = $room["room_id"];
                                $users = get_room_players($db, $room_id);
                                $is_joined = check_is_joined($db, $room_id, $_SESSION['user_id']);

                                if (sizeof($users) < $room["member_num"] || $is_joined == true) {
                                    $spaces_available = $room["member_num"] - sizeof($users);

                                    if ($is_joined == true) {
                                        $btn_join = "Rejoin";
                                    } else {
                                        $btn_join = "Join";
                                    }

                                    echo "<div class='item'>";
                                    echo "<div class='item-type'>Who's the Ghost?";
                                    if ($room["room_name"] != null) {
                                        echo " - <span class='item-name'>" . $room["room_name"] . "</span>";
                                    }
                                    echo "</div>";
                                    echo "<div class='item-spaces'>Spaces available: " . $spaces_available . "</div>";
                                    echo "<div class='players'>";
                                    foreach ($users as $user):
                                        $player_info = get_room_player_info($db, $user["user_id"]);

                                        echo "<a href='profile.php?id=" . $user["user_id"] . "'><img class='player' src='images/profiles/" . $player_info["profile_pic"] . "' title='" . $player_info["first_name"] . " " . $player_info["last_name"] . "' alt='" . $player_info["first_name"] . " " . $player_info["last_name"] . "'></a>";
                                    endforeach;
                                    echo "</div>";
                                    echo "<form action='ghost/enter_room_action.php' method='post'>";
                                    echo "<input type='hidden' name='room_id' value='" . $room_id . "'>";
                                    echo "<button type='submit' class='btn btn-item'>" . $btn_join . "<i class='fa fa-chevron-right' aria-hidden='true'></i></button>";
                                    echo "</form>";
                                    echo "</div>";
                                }
                            }
                        } else {
                            echo "<div id='message'><i class='fa fa-info-circle' aria-hidden='true'></i>No rooms available at the moment. Refresh or open yours now!</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <script src="scripts/viewport-resize.js"></script>
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