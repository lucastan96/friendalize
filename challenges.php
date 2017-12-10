<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
} else {
    require_once('includes/essentials.php');

    $rooms = get_rooms($db);

    $query1 = "SELECT interests FROM user_interests  WHERE user_id = :user_id";
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(":user_id", $_SESSION['user_id']);
    $statement1->execute();
    $results_array1 = $statement1->fetch();
    $statement1->closeCursor();

    $interest_ids = $results_array1["interests"];

    if (empty($interest_ids)) {
        $interests_array = [];
        $size_array = 0;
    } else {
        $interests_array = explode(",", $interest_ids);
        $size_array = sizeof($interests_array);
    }
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
                                <label class="control-label" for="member_num">Interest:</label>
                                <select class='form-control form-select' id="int_id" name="int_id" required>
                                    <?php
                                    if ($size_array == 0) {
                                        echo '<option value="2" selected="selected" >Music</option>';
                                    } else {
                                        for ($i = 0; $i < $size_array; $i++) {
                                            $query2 = "SELECT name FROM interests WHERE interest_id = :interest_id";
                                            $statement2 = $db->prepare($query2);
                                            $statement2->bindValue(":interest_id", $interests_array[$i]);
                                            $statement2->execute();
                                            $results_array2 = $statement2->fetch();
                                            $statement2->closeCursor();
                                            echo '<option value="' . $interests_array[$i] . '">' . htmlspecialchars($results_array2["name"]) . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="difficulty">Difficulty Level:</label>
                                <select class='form-control form-select' id="difficulty" name="difficulty" required>
                                    <option value="" selected="selected">Easy, medium, or hard?</option>
                                    <option value="1">Easy</option>
                                    <option value="2">Medium</option>
                                    <option value="3">Hard</option>
                                </select>
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

                                    $query3 = "SELECT name FROM interests WHERE interest_id = :interest_id";
                                    $statement3 = $db->prepare($query3);
                                    $statement3->bindValue(":interest_id", $room["interest_id"]);
                                    $statement3->execute();
                                    $interest_result = $statement3->fetch();
                                    $statement3->closeCursor();
                                    
                                    $interest = $interest_result["name"];
                                    
                                    if ($room["difficulty_id"] == 1) {
                                        $difficulty = "Easy";
                                    } else if ($room["difficulty_id"] == 2) {
                                        $difficulty = "Medium";
                                    } else {
                                        $difficulty = "Hard";
                                    }

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
                                    echo "<a href='#' role='button' class='btn btn-default btn-help' data-toggle='tooltip' data-placement='bottom' data-html='true' title='<h5>Game Rules</h5><br><p>At the beginning of the game, every player will receive a word.</p><p>Every player will have the same word, except one whom he or she will get a similar but different word, and we call him the <b>ghost</b>!</p><p>Players will take turns to describe their word without giving the actual word away. After one full round, players will need to vote who’s the ghost. The player with the highest vote will not be able to continue the game.</p><p>If he is the ghost, the game is over. If he is not, the game continues for another round.</p>'>?</a>";
                                    echo "</div>";
                                    echo "<div class='item-spaces'>Spaces available: " . $spaces_available . " | " . $interest . " | Difficulty: " . $difficulty . "</div>";
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
                $('[data-toggle="tooltip"]').tooltip();   
            });

            var width = $('.nav-mobile a:nth-child(1)').width() + $('.nav-mobile a:nth-child(2)').width() + $('.nav-mobile a:nth-child(3)').width();
            $('.nav-mobile').scrollLeft(width);
        </script>
    </body>
</html>