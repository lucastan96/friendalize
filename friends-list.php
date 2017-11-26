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
                    <p>Under Construction</p>
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