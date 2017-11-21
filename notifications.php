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
        <title>Notifications | Friendalize</title>
        <link href="styles/messages.css" rel="stylesheet">
    </head>
    <body>
        <div class="container-fluid">
            <?php include("includes/navbar.php"); ?>
            <div class="row cols">
                <?php include("includes/nav-desktop.php"); ?>
                <?php include("includes/nav-mobile.php"); ?>
                <div class="col-sm-10 content">
                    <h1>Notifications</h1>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('.navbar-right li:nth-child(2)').addClass("navbar-active");
            });
        </script>
    </body>
</html>