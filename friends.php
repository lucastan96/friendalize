<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
} else {
    require_once('includes/essentials.php');

    $friend_count = get_friend_count($db, $_SESSION['user_id']);

    if ($friend_count != 0) {
        $friends = get_friends($db, $_SESSION['user_id']);
    } else {
        $friends = [];
    }

    $users = get_all_users($db);
    $requested_ids = check_friend_requests($db, $_SESSION['user_id']);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("includes/head.php"); ?>
        <title>Friends | Friendalize</title>
        <link href="scripts/dead-simple-grid-gh-pages/css/grid.css" rel="stylesheet">
        <link href="styles/friends.css" rel="stylesheet">
    </head>
    <body>
        <div class="container-fluid">
            <?php include("includes/navbar.php"); ?>
            <div class="row cols">
                <?php include("includes/nav-desktop.php"); ?>
                <?php include("includes/nav-mobile.php"); ?>
                <div class="col-sm-10 content">
                    <h1>Your Friends (<?php echo $friend_count; ?>)</h1>
                    <?php if ($friend_count != 0) { ?>
                        <div class='friends-list'>
                            <?php
                            if (sizeof($friends) <= 12) {
                                $friend_list_size = sizeof($friends);
                            } else {
                                $friend_list_size = 12;
                            }

                            for ($i = 0; $i < $friend_list_size; $i++) {
                                $friend_id = $friends[$i];

                                $query = "SELECT profile_pic, first_name, last_name FROM users WHERE user_id = :friend_id";
                                $statement = $db->prepare($query);
                                $statement->bindValue(":friend_id", $friend_id);
                                $statement->execute();
                                $friend_details = $statement->fetchAll();
                                $statement->closeCursor();

                                foreach ($friend_details as $details):
                                    $friend_profile_pic = $details["profile_pic"];
                                    $friend_first_name = $details["first_name"];
                                    $friend_last_name = $details["last_name"];
                                endforeach;

                                echo "<a class='friends-list-item' href='profile.php?id=" . $friend_id . "' title='" . $friend_first_name . " " . $friend_last_name . "'><img src='images/profiles/" . $friend_profile_pic . "'></a>";
                            }
                            ?>
                            <a class='friends-list-item btn btn-default btn-friend-list' role='button' href='friends-list.php'>View All<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </div>
                    <?php } else { ?>
                        <div id='message'><i class='fa fa-info-circle' aria-hidden='true'></i>You have not added any friends just yet. Get <span>friendalized</span> now!</div>
                    <?php } ?>
                    <?php if (!empty($requested_ids)) { ?>
                        <h2>Friend Requests</h2>
                        <div class="users-list">
                            <div class="row">
                                <?php
                                foreach ($users as $user):
                                    if (in_array($user["user_id"], $requested_ids)) {
                                        $query1 = "SELECT profile_pic, first_name, last_name FROM users WHERE user_id = :user_id";
                                        $statement1 = $db->prepare($query1);
                                        $statement1->bindValue(":user_id", $user["user_id"]);
                                        $statement1->execute();
                                        $user_details = $statement1->fetchAll();
                                        $statement1->closeCursor();

                                        foreach ($user_details as $details):
                                            $user_profile_pic = $details["profile_pic"];
                                            $user_first_name = $details["first_name"];
                                            $user_last_name = $details["last_name"];
                                        endforeach;

                                        $user_institution = get_user_institution($db, $user["user_id"]);
                                        $user_interests = get_user_interests($db, $user["user_id"]);

                                        if ($user_interests == "") {
                                            $user_interests = "No interests yet";
                                        }
                                        ?>
                                        <div class='col'>
                                            <a href="profile.php?id=<?php echo $user["user_id"]; ?>" class='users-list-item-link'>
                                                <div class="users-list-item-container">
                                                    <img src="images/profiles/<?php echo $user_profile_pic; ?>">
                                                    <div class='users-list-item-info'>
                                                        <div class="users-list-name"><?php echo $user_first_name . " " . $user_last_name; ?></div>
                                                        <p><?php echo $user_institution; ?></p>
                                                        <p><?php echo $user_interests; ?></p>
                                                    </div>
                                                    <form action="includes/friend-add-p.php" method="post">
                                                        <input type="hidden" name="friend_id" value="<?php echo $user["user_id"]; ?>">
                                                        <button class="btn btn-default btn-accept" type="submit">Accept</button>
                                                    </form>
                                                </div>
                                            </a>
                                        </div>
                                        <?php
                                    }
                                endforeach;
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                    <h2>People You May Know</h2>
                    <div class='users-list'>
                        <div class='row'>
                            <?php
                            foreach ($users as $user):
                                if (!in_array($user["user_id"], $friends) && $user["user_id"] != $_SESSION['user_id'] && !in_array($user["user_id"], $requested_ids)) {
                                    $query1 = "SELECT profile_pic, first_name, last_name FROM users WHERE user_id = :user_id";
                                    $statement1 = $db->prepare($query1);
                                    $statement1->bindValue(":user_id", $user["user_id"]);
                                    $statement1->execute();
                                    $user_details = $statement1->fetchAll();
                                    $statement1->closeCursor();

                                    foreach ($user_details as $details):
                                        $user_profile_pic = $details["profile_pic"];
                                        $user_first_name = $details["first_name"];
                                        $user_last_name = $details["last_name"];
                                    endforeach;

                                    $user_institution = get_user_institution($db, $user["user_id"]);
                                    $user_interests = get_user_interests($db, $user["user_id"]);

                                    if ($user_interests == "") {
                                        $user_interests = "No interests yet";
                                    }
                                    ?>
                                    <div class='col'>
                                        <a href="profile.php?id=<?php echo $user["user_id"]; ?>" class='users-list-item-link'>
                                            <div class="users-list-item-container">
                                                <img src="images/profiles/<?php echo $user_profile_pic; ?>">
                                                <div class='users-list-item-info'>
                                                    <div class="users-list-name"><?php echo $user_first_name . " " . $user_last_name; ?></div>
                                                    <p><?php echo $user_institution; ?></p>
                                                    <p><?php echo $user_interests; ?></p>
                                                </div>    
                                            </div>
                                        </a>
                                    </div>
                                    <?php
                                }
                            endforeach;
                            ?>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
        <script src="scripts/viewport-resize.js"></script>
        <script>
            $(document).ready(function () {
                $('.nav-desktop li:nth-child(3)').addClass("nav-active");
                $('.nav-mobile a:nth-child(3)').addClass("nav-active");
            });

            var width = $('.nav-mobile a:nth-child(1)').width() + $('.nav-mobile a:nth-child(2)').width();
            $('.nav-mobile').scrollLeft(width);
        </script>
    </body>
</html>