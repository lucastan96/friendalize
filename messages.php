<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
} else {
    require_once('includes/essentials.php');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("includes/head.php"); ?>
        <title>Messages | Friendalize</title>
        <link href="styles/messages.css" rel="stylesheet">
    </head>
    <body>
        <div class="container-fluid">
            <?php include("includes/navbar.php"); ?>
            <div class="row cols">
                <?php include("includes/nav-desktop.php"); ?>
                <?php include("includes/nav-mobile.php"); ?>
                <div class="col-sm-10 content">
                    <h1>Messages</h1>
                </div>
            </div>
        </div>
        <script src="scripts/viewport-resize.js"></script>
        <script>
            $(document).ready(function () {
                $('.nav-desktop li:nth-child(5)').addClass("nav-active");
                $('.nav-mobile a:nth-child(5)').addClass("nav-active");
            });
            
            var width = $('.nav-mobile a:nth-child(1)').width() + $('.nav-mobile a:nth-child(2)').width() + $('.nav-mobile a:nth-child(3)').width() + $('.nav-mobile a:nth-child(4)').width();
            $('.nav-mobile').scrollLeft(width);
        </script>
    </body>
</html>