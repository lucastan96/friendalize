<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: http://localhost/friendalize/signin");
    exit();
} else {
    require_once('includes/essentials.php');

    $friend_count = get_friend_count($db, $_SESSION['user_id']);

    if ($friend_count != 0) {
        $friends = get_friends($db, $_SESSION['user_id']);
        sort($friends);
    } else {
        $friends = [];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("includes/head.php"); ?>
        <title>All Added Friends | Friendalize</title>
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
                    <h1>All Added Friends (<?php echo $friend_count; ?>)</h1>
                    <div class='users-list'>
                        <div class='row'>
                            <?php
                            for ($i = 0; $i < sizeof($friends); $i++) {
                                $query1 = "SELECT profile_pic, first_name, last_name FROM users WHERE user_id = :user_id";
                                $statement1 = $db->prepare($query1);
                                $statement1->bindValue(":user_id", $friends[$i]);
                                $statement1->execute();
                                $friend_details = $statement1->fetchAll();
                                $statement1->closeCursor();

                                foreach ($friend_details as $details):
                                    $friend_profile_pic = $details["profile_pic"];
                                    $friend_first_name = $details["first_name"];
                                    $friend_last_name = $details["last_name"];
                                endforeach;

                                $friend_institution = get_user_institution($db, $friends[$i]);
                                $friend_interests = get_user_interests($db, $friends[$i]);

                                if ($friend_interests == "") {
                                    $friend_interests = "No interests yet";
                                }
                                ?>
                                <div class='col'>
                                    <a href="profile.php?id=<?php echo $friends[$i]; ?>" class='users-list-item-link'>
                                        <div class="users-list-item-container">
                                            <img src="images/profiles/<?php echo $friend_profile_pic; ?>">
                                            <div class='users-list-item-info'>
                                                <div class="users-list-name"><?php echo $friend_first_name . " " . $friend_last_name; ?></div>
                                                <p><?php echo $friend_institution; ?></p>
                                                <p><?php echo $friend_interests; ?></p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php
                            }
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