<?php
require_once('../includes/connection.php');
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
$query2 = 'SELECT * FROM ghost_room_players rm, ghost_answer_submit gas  WHERE rm.room_id = gas.room_id and rm.room_id = :room_id AND  rm.user_id=:user_id AND gas.voter =:voter_id';
$statement2 = $db->prepare($query2);
$statement2->execute(array(":room_id" => $_SESSION["room_id"], ":user_id" => $_SESSION["user_id"],":voter_id" => $_SESSION["user_id"]));
$player = $statement2->fetch();
$statement2->closeCursor();

$query4 = 'SELECT * FROM ghost_game_time WHERE room_id = :room_id';
$statement4 = $db->prepare($query4);
$statement4->execute(array(":room_id" => $_SESSION["room_id"]));
$r = $statement4->fetch();
$statement4->closeCursor();

$_SESSION["start_time"] = $r["start_time"];

$queryStart = false;
$wordTime;
$playerTime = array();

$start_time = $_SESSION['start_time'];
$start_time_s = date("Y-m-d H:i:s", strtotime($start_time));
$curTime = date("Y-m-d H:i:s", time());
$query13= 'SELECT count(*) as count_died FROM `ghost_room_players` WHERE room_id=:room_id and died = 0';
$statement13 = $db->prepare($query13);
$statement13->execute(array(":room_id" => $_SESSION["room_id"]));
$r3 = $statement13->fetch();
$statement13->closeCursor();
$count = $r3['count_died'];
if($start_time_s=='1970-01-01 01:00:00'){
  // header("Location: room.php?room_id=".$_SESSION["room_id"]);
  // exit();
  echo "<script>top.window.location = 'restart.php' </script>";
  die;
}

if($curTime < $start_time_s && isset($_SESSION['result_message'])&& isset($_SESSION['next_round'])){
  $to_time = strtotime($start_time_s);
  $from_time = strtotime($curTime);
  $diff = abs($to_time - $from_time);
  echo '<input type="hidden" id = "diff" value="' . $diff . '">';
  echo $_SESSION['result_message'];
}
else{
  if(isset($_SESSION['die']) && $_SESSION['die']==true && $count !=1){
    echo '<br>';
    echo 'please wait for new game start';
    echo '<br>';
    echo '<input type="hidden" id = "diff" value="0">';
  }
  if($count !=1){
    if(!isset($_SESSION['next_round'])){
      $wordTime = date("Y-m-d H:i:s", strtotime($start_time) + 5);
    }else if(isset($_SESSION["next_round"])){
      $wordTime = date("Y-m-d H:i:s", strtotime($start_time));
    }
    $playerTime[1] = date("Y-m-d H:i:s", strtotime($wordTime) + 5);
    for ($i = 2; $i <= $count ; $i++) {
      $playerTime[$i] = date("Y-m-d H:i:s", strtotime($playerTime[$i - 1]) + 5);
    }

    if ($wordTime > $start_time_s&&  $curTime < $wordTime) {
      $to_time = strtotime($wordTime);
      $from_time = strtotime($curTime);
      $diff = abs($to_time - $from_time);
      echo '<input type="hidden" id = "diff" value="' . $diff . '">';
      echo '<br>';
      echo "<p>Please remember the word given!</p>";
      echo '<h1>';
      echo $player["word"];
      echo '</h1>';
    }
    else if ($curTime >= $wordTime && $curTime < $playerTime[1]) {
      //SELECT MIN(game_order) FROM ghost_room_players r, users p WHERE r.room_id=1 AND p.user_id = r.user_id AND r.died=0;
      unset($_SESSION['result_message']);
      unset($_SESSION['vote']);
      $queryStart = true;
      $query5 = 'SELECT * FROM ghost_room_players r, users p WHERE r.room_id=:room_id AND r.game_order=(SELECT game_order FROM ghost_room_players r, users p WHERE r.room_id=:min_room_id AND p.user_id = r.user_id AND r.died=0 order by game_order Limit 0,1 ) AND p.user_id = r.user_id';
      $to_time = strtotime($playerTime[1]);
      $from_time = strtotime($curTime);
      $diff = abs($to_time - $from_time);
      echo '<input type="hidden" id = "diff" value="' . $diff . '">';
    } else if ($curTime >= $playerTime[1]  && $curTime < $playerTime[2]) {
      $queryStart = true;
      $query5 = 'SELECT * FROM ghost_room_players r, users p WHERE r.room_id=:room_id AND r.game_order=(SELECT game_order FROM ghost_room_players r, users p WHERE r.room_id=:min_room_id AND p.user_id = r.user_id AND r.died=0 order by game_order Limit 1,1 ) AND p.user_id = r.user_id';
      $to_time = strtotime($playerTime[2]);
      $from_time = strtotime($curTime);
      $diff = abs($to_time - $from_time);
      echo '<input type="hidden" id = "diff" value="' . $diff . '">';
    } else if (isset($playerTime[3]) && $curTime >= $playerTime[2] && $curTime < $playerTime[3]) {
      $queryStart = true;
      $query5 = 'SELECT * FROM ghost_room_players r, users p WHERE r.room_id=:room_id AND r.game_order=(SELECT game_order FROM ghost_room_players r, users p WHERE r.room_id=:min_room_id AND p.user_id = r.user_id AND r.died=0 order by game_order Limit 2,1 ) AND p.user_id = r.user_id';
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
    else if ( $curTime >= $playerTime[$count]) {
      if (!isset($_SESSION["vote"]) && !isset($_SESSION['die'])) {
        $query6 = 'SELECT * FROM ghost_room_players r, users p WHERE r.room_id=:room_id AND p.user_id = r.user_id AND r.died =0';
        $statement6 = $db->prepare($query6);
        $statement6->execute(array(":room_id" => $_SESSION["room_id"]));
        $players = $statement6->fetchAll();
        $statement6->closeCursor();
        echo '<form>';
        foreach ($players as $p) {
          echo '<input type="radio" name="voted_id" value="' . $p["user_id"] . '"> ' . $p["username"] . '<br>';
        }
        echo "<br>";
        echo '<button type="button" class="btn btn-square" id="vote-btn" onclick="voteButton()" value="Submit">Vote</button>';
        echo '</form>';

      }
      else {
        $query7 = 'SELECT count(*) as count_0 FROM ghost_answer_submit WHERE room_id=:room_id and voted = 0';
        $statement7 = $db->prepare($query7);
        $statement7->execute(array(":room_id" => $_SESSION["room_id"]));
        $r = $statement7->fetch();
        $statement7->closeCursor();
        $count_0 = $r["count_0"];
        $draw = false;
        if ($count_0 == $_SESSION['die_num']) {
          $query8 = 'SELECT voted, COUNT(voted) AS value_occurrence FROM ghost_answer_submit WHERE room_id=:room_id GROUP BY voted ORDER BY value_occurrence';
          $statement8 = $db->prepare($query8);
          $statement8->execute(array(":room_id" => $_SESSION["room_id"]));
          $answer = $statement8->fetchAll();
          $statement8->closeCursor();

          $max = 0;
          $die_id = 0;
          foreach ($answer as $a) {
            if ($a["value_occurrence"] > $max) {
              $die_id = $a["voted"];
              $max = $a["value_occurrence"];
            }
          }
          foreach ($answer as $a) {
            if ($a["value_occurrence"] == $max && $die_id != $a["voted"]) {
              $draw = true;
              $die_id=0;
            }
          }
          if ($draw) {
            $_SESSION["next_round"] = true;
            $_SESSION['result_message'] = "Ghost not found";
            if(isset($_SESSION['result_message'])&& isset($_SESSION["next_round"]) && $_SESSION['next_round'] &&$player['vote_order'] ==(3-$_SESSION['die_num'])){

              $newTime = date("Y-m-d H:i:s", time()+5);
              $query12 = 'UPDATE  ghost_game_time SET start_time=:start_time WHERE room_id=:room_id';
              $statement12 = $db->prepare($query12);
              $statement12->execute(array(":room_id" => $_SESSION["room_id"], ":start_time" => $newTime));
              $statement12->closeCursor();
              $query15 = 'UPDATE ghost_answer_submit SET voted=0 ,vote_order=0 WHERE room_id = :room_id';
              $statement15 = $db->prepare($query15);
              $statement15->execute(array(":room_id" => $_SESSION["room_id"]));
              $statement15->closeCursor();
            }
            echo '<input type="hidden" id = "diff" value="0">';
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
              // $_SESSION['result_message'] = "<p>The <b>ghost</b> was found, it was " . $die_user["username"] . "!</p>";
              echo "<p>The <b>ghost</b> was found, it was " . $die_user["username"] . "!</p>";
              echo '<br>';
              echo '<a href="restart.php" role="button" class="btn btn-square">Next Game</a>';
            } else if($count !=1){
              if($die_id == $_SESSION['user_id']){
                $_SESSION['die']=true;
              }
              $_SESSION["next_round"] = true;
              $_SESSION['result_message'] = "<p>The <b>ghost</b> was not found!</p><br><p>However, " . $die_user["username"] . " will be kicked out from the room!</p>";
              $query11 = 'UPDATE `ghost_room_players` SET died=1 WHERE user_id=:user_id AND room_id = :room_id';
              $statement11 = $db->prepare($query11);
              $statement11->execute(array(":user_id" => $die_id,":room_id" => $_SESSION["room_id"]));
              $statement11->closeCursor();
              if(isset($_SESSION['result_message'])&& isset($_SESSION["next_round"]) && $_SESSION['next_round'] &&$player['vote_order'] ==(3-$_SESSION['die_num'])){

                $newTime = date("Y-m-d H:i:s", time()+5);
                $query12 = 'UPDATE  ghost_game_time SET start_time=:start_time WHERE room_id=:room_id';
                $statement12 = $db->prepare($query12);
                $statement12->execute(array(":room_id" => $_SESSION["room_id"], ":start_time" => $newTime));
                $statement12->closeCursor();
                $query15 = 'UPDATE ghost_answer_submit SET voted=0 ,vote_order=0 WHERE room_id = :room_id';
                $statement15 = $db->prepare($query15);
                $statement15->execute(array(":room_id" => $_SESSION["room_id"]));
                $statement15->closeCursor();
              }
              $_SESSION['die_num'] = $_SESSION['die_num'] +1;
              echo '<input type="hidden" id = "diff" value="0">';
            }
          }
        } else if(!isset($_SESSION['die'])){
          echo '<input type="hidden" id = "diff" value="0">';
          echo "<p>Please wait for the other players to vote...</p>";
        }

      }
    }
    if ($queryStart && !isset($_SESSION['die'])) {
      $statement5 = $db->prepare($query5);
      $statement5->execute(array(":room_id" => $_SESSION["room_id"],":min_room_id"=>$_SESSION["room_id"]));
      $curr_player = $statement5->fetch();
      $statement5->closeCursor();

      if ($curr_player["user_id"] == $_SESSION["user_id"]) {
        echo "<p>Please describe your word in one sentence. Remember, it's better not to be too obvious!</p>";
        echo '<p>If you think you are the ghost (the person with a different word), you should pretend that you are not!</p>';
      } else if (!empty($curr_player)) {
        echo '<p>It is ' . $curr_player["username"] . "'s turn!</p>";
        echo '<p>Please wait...</p>';
      }
    }

  }else{
    echo '<p>Ghost Win</p>';
    echo '<br>';
    echo '<a href="restart.php" role="button" class="btn btn-square">Next Game</a>';
  }
}
?>

<script>
var diff = document.getElementById('diff').value;
reset(diff);
countdown();

</script>
