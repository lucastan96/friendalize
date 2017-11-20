<?php
require_once('../includes/connection.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$query3 = 'SELECT COUNT(*) as num_ready FROM ghost_room r , ghost_room_players rp WHERE r.room_id = rp.room_id AND r.room_id = :room_id AND rp.ready = 1';
$statement3 = $db->prepare($query3);
$statement3->execute(array(":room_id" => $_SESSION["room_id"]));
$result = $statement3->fetch();
$statement3->closeCursor();

$ready = $result["num_ready"];
$diff = 0;
if ($ready == 3) {
    $query2 = 'SELECT * FROM ghost_room_players WHERE room_id = :room_id AND  user_id=:user_id';
    $statement2 = $db->prepare($query2);
    $statement2->execute(array(":room_id" => $_SESSION["room_id"], ":user_id" => $_SESSION["user_id"]));
    $player = $statement2->fetch();
    $statement2->closeCursor();


    $query4 = 'SELECT * FROM ghost_game_time WHERE room_id = :room_id';
    $statement4 = $db->prepare($query4);
    $statement4->execute(array(":room_id" => $_SESSION["room_id"]));
    $r = $statement4->fetch();
    $statement4->closeCursor();

    if (!empty($r)) {
        $_SESSION["start_time"] = $r["start_time"];
    } else {
        $_SESSION["start_time"] = "";
    }

    $queryStart = false;
    $start_time;
    $wordTime;
    $playerTime = array();
    if (!empty($_SESSION["start_time"])) {
        $start_time = $_SESSION['start_time'];

        $wordTime = date("Y-m-d H:i:s", strtotime($start_time) + 10);
        $playerTime[1] = date("Y-m-d H:i:s", strtotime($wordTime) + 20);
        for ($i = 2; $i <= 3; $i++) {
            $playerTime[$i] = date("Y-m-d H:i:s", strtotime($playerTime[$i - 1]) + 20);
        }

//        $answerTime = date("Y-m-d H:i:s", strtotime($playerTime[5]) + 30);
        $curTime = date("Y-m-d H:i:s", time());
    }
    if (!empty($_SESSION['start_time']) && $curTime < $wordTime) {

        $to_time = strtotime($wordTime);
        $from_time = strtotime($curTime);
        $diff = abs($to_time - $from_time);
        echo '<input type="hidden" id = "diff" value="' . $diff . '">';
        echo '<br>';
        echo "Please remember the word given";
        echo '<h1>';
        echo $player["word"];
        echo '</h1>';
    } else if (!empty($_SESSION['start_time']) && $curTime < $playerTime[1]) {
        $queryStart = true;
        $query5 = 'SELECT * FROM ghost_room_players r, users p WHERE r.room_id=:room_id AND r.game_order=1 AND p.user_id = r.user_id';
        $to_time = strtotime($playerTime[1]);
        $from_time = strtotime($curTime);
        $diff = abs($to_time - $from_time);
        echo '<input type="hidden" id = "diff" value="' . $diff . '">';
    } else if (!empty($_SESSION['start_time']) && $curTime < $playerTime[2]) {
        $queryStart = true;
        $query5 = 'SELECT * FROM ghost_room_players r, users p WHERE r.room_id=:room_id AND r.game_order=2 AND p.user_id = r.user_id';
        $to_time = strtotime($playerTime[2]);
        $from_time = strtotime($curTime);
        $diff = abs($to_time - $from_time);
        echo '<input type="hidden" id = "diff" value="' . $diff . '">';
    } else if (!empty($_SESSION['start_time']) && $curTime < $playerTime[3]) {
        $queryStart = true;
        $query5 = 'SELECT * FROM ghost_room_players r, users p WHERE r.room_id=:room_id AND r.game_order=3 AND p.user_id = r.user_id';
        $to_time = strtotime($playerTime[3]);
        $from_time = strtotime($curTime);
        $diff = abs($to_time - $from_time);
        echo '<input type="hidden" id = "diff" value="' . $diff . '">';
    }
//    else if (!empty($_SESSION['start_time']) && $curTime < $playerTime[4]) {
//        $queryStart = true;
//        $query5 = 'SELECT * FROM ghost_room_players r, users p WHERE r.room_id=:room_id AND r.game_order=4 AND p.user_id = r.user_id';
//        $to_time = strtotime($playerTime[4]);
//        $from_time = strtotime($curTime);
//        $diff = abs($to_time - $from_time);
//        echo '<input type="hidden" id = "diff" value="' . $diff . '">';
//    } else if (!empty($_SESSION['start_time']) && $curTime < $playerTime[5]) {
//        $queryStart = true;
//        $query5 = 'SELECT * FROM ghost_room_players r, users p WHERE r.room_id=:room_id AND r.game_order=5 AND p.user_id = r.user_id';
//        $to_time = strtotime($playerTime[5]);
//        $from_time = strtotime($curTime);
//        $diff = abs($to_time - $from_time);
//        echo '<input type="hidden" id = "diff" value="' . $diff . '">';
//    } 
    else if (!empty($_SESSION['start_time']) && $curTime > $playerTime[3]) {
        if (!isset($_SESSION["vote"])) {
            $query6 = 'SELECT * FROM ghost_room_players r, users p WHERE r.room_id=:room_id AND p.user_id = r.user_id';
            $statement6 = $db->prepare($query6);
            $statement6->execute(array(":room_id" => $_SESSION["room_id"]));
            $players = $statement6->fetchAll();
            $statement6->closeCursor();
            echo '<form>';
            foreach ($players as $p) {

                echo '<input type="radio" name="voted_id" value="' . $p["user_id"] . '"> ' . $p["username"] . '<br>';
            }
            echo '<button type="button" id="vote-btn" value="Submit">Submit</button>';
            echo '</form>';
        } else {

//    } else if (!empty($_SESSION['start_time']) && $curTime > $answerTime) {
            $query7 = 'SELECT count(*) as count_0 FROM ghost_answer_submit WHERE room_id=:room_id and voted = 0';
            $statement7 = $db->prepare($query7);
            $statement7->execute(array(":room_id" => $_SESSION["room_id"]));
            $r = $statement7->fetch();
            $statement7->closeCursor();
            $count_0 = $r["count_0"];
            $draw = false;
            if ($count_0 == 0) {
                $query8 = 'SELECT voted, COUNT(voted) AS value_occurrence FROM ghost_answer_submit WHERE room_id=:room_id GROUP BY voted ORDER BY value_occurrence';
                $statement8 = $db->prepare($query8);
                $statement8->execute(array(":room_id" => $_SESSION["room_id"]));
                $answer = $statement8->fetchAll();
                $statement8->closeCursor();

                $max = 0;
                $die_id = 0;
                foreach ($answer as $a) {
                    if ($a["value_occurrence"] > $max) {
//            echo $a["value_occurrence"];
                        $die_id = $a["voted"];
                        $max = $a["value_occurrence"];
                    }
                }
                foreach ($answer as $a) {
                    if ($a["value_occurrence"] == $max && $die_id != $a["voted"]) {
                        $draw = true;
                    }
                }
                if ($draw) {
                    echo "Ghost not found";

                } else if (!$draw) {
                    $query10 = 'SELECT wp.ghost_word FROM ghost_room_players rp, ghost_room r, ghost_word_pair wp WHERE rp.room_id = r.room_id and r.word_pair_id = wp.word_pair_id and rp.user_id = :user_id and rp.room_id = :room_id';
                    $statement10 = $db->prepare($query10);
                    $statement10->execute(array(":user_id" => $die_id, ":room_id" => $_SESSION["room_id"]));
                    $r2 = $statement10->fetch();
                    $statement10->closeCursor();
                    $ghost_word = $r2["ghost_word"];

                    $query9 = 'SELECT * FROM users p, ghost_room_players rp WHERE p.user_id =rp.user_id AND rp.user_id = :user_id AND rp.room_id = :room_id';
                    $statement9 = $db->prepare($query9);
                    $statement9->execute(array(":user_id" => $die_id, ":room_id" => $_SESSION["room_id"]));
                    $die_user = $statement9->fetch();
                    $statement9->closeCursor();

                    if ($ghost_word == $die_user["word"]) {
                        echo "GHOST found";
                        echo "<br>";
                        echo "The GHOST is ";
                        echo "<br>";
                        echo $die_user["username"];
                        
                    } else {
                        echo "GHOST was not found";
                        echo "<br>";
                        echo "BUT";
                        echo "<br>";
                        echo $die_user["usernamex"];
                        echo "<br>";
                        echo "Will be kick out from the room";
                        $query11 = 'UPDATE `ghost_room_players` SET died=1 WHERE user_id=:user_id';
                        $statement11 = $db->prepare($query11);
                        $statement11->execute(array(":user_id" => $die_id));
                        $statement11->closeCursor();
//                         echo '<input type="hidden" id = "diff" value="30">';
                    }
                }
                                        echo '<a href="restart.php" role="button" class="btn btn-default">Next Game</a>';
            } else {
                echo '<input type="hidden" id = "diff" value="0">';
                echo "Wait for other players to vote";
            }
        }
    }
    if ($queryStart) {
        $statement5 = $db->prepare($query5);
        $statement5->execute(array(":room_id" => $_SESSION["room_id"]));
        $curr_player = $statement5->fetch();
        $statement5->closeCursor();
        if ($curr_player["user_id"] == $_SESSION["user_id"]) {
            echo 'Please describe the your word in 1 sentence, it is better not to be too obvious.';
            echo 'If you think you are the GHOST(the one with different word, it is better to pretend you are not.';
        } else if (!empty($curr_player)) {
            echo 'It is ' . $curr_player["username"] . "'s turn";
            echo '<br>';
            echo 'Please wait';
        }
    }
    echo '<input type="hidden" id = "diff" value="-1">';

//    <!--<span id="countdown" class="timer"></span>
//    <script>
//    var seconds = 30;
//    function secondPassed() {
//    var remainingSeconds = seconds % 60;
//
//    //document.getElementById("countdown").innerHTML = "0" + minutes + ":" + remainingSeconds;
//
//    if (remainingSeconds <= 30) {
//
//    document.getElementById("countdown").style.color = "green";
//    document.getElementById("countdown").innerHTML = "0" + "0" + ":" + remainingSeconds;
//    }
//    if (remainingSeconds <= 20) {
//    document.getElementById("countdown").style.color = "orange";
//    document.getElementById("countdown").innerHTML = "0" + "0" + ":" + remainingSeconds;
//
//    }
//    if (remainingSeconds < 10) {
//    document.getElementById("countdown").style.color = "red";
//    document.getElementById("countdown").innerHTML = "0" + "0" + ":0" + remainingSeconds;
//
//    }
//    if (seconds === 0) {
//    document.getElementById('countdown').innerHTML = "Time Over!!";
//    } else {
//    seconds--;
//    }
//    }
//
//    var countdownTimer = setInterval('secondPassed()', 1000);
//    </script>-->
} else {
    echo '<input type="hidden" id = "diff" value="0">';
    echo 'Waiting everyone to get ready';
}
?>


<script>
    var diff = document.getElementById('diff').value;
    reset(diff);
    countdown();

</script>